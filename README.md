# ci4-api-core-example

Exact output of [`dcardenasl/ci4-api-core`](https://packagist.org/packages/dcardenasl/ci4-api-core) + [`dcardenasl/ci4-api-scaffolding`](https://packagist.org/packages/dcardenasl/ci4-api-scaffolding) applied to a fresh `codeigniter4/appstarter` project.

Two resources — **Categories** and **Products** — in a **Catalog** domain. The git history records each command as its own commit so you can read the exact diff of what each package generates vs what you write by hand.

> **Scope of this repo:** scaffold output + one hand-written `enrichEntities()` method. Nothing more.

---

## How this was built

**1. Create the CI4 project:**

```bash
composer create-project codeigniter4/appstarter ci4-api-core-example
cd ci4-api-core-example
git init && git add . && git commit -m "chore: scaffold ci4 project with codeigniter4/appstarter"
```

**2. Install the runtime library and wire the service factories:**

```bash
composer require dcardenasl/ci4-api-core:^0.5
cp env .env   # fill in DB credentials
php spark core:install
```

Output of `core:install`:

```
  ✓  Created  app/Config/ApiCoreServices.php
  ✓  Patched  app/Config/Services.php (backup: Services.php.bak)
  ✓  Patched  app/Config/Routes.php (backup: Routes.php.bak)

  ✓  Services::auditService()
  ✓  Services::requestAuditContextFactory()
  ✓  Services::requestDtoFactory()
  ✓  Services::requestDataCollector()
  ✓  Routes.php: GET /health
```

`core:install` generates `app/Config/ApiCoreServices.php`, patches `app/Config/Services.php` (trait + request factory override), and injects a `GET /health` endpoint into `app/Config/Routes.php` backed by `HealthChecker::checkAll()`.

At this point `curl http://localhost:8080/health` already responds.

**3. Install the scaffolding engine:**

```bash
composer require --dev dcardenasl/ci4-api-scaffolding:^0.3
```

**4. Generate both resources:**

```bash
bash vendor/bin/make-crud.sh Category Catalog \
  'name:string:required|searchable' \
  yes

bash vendor/bin/make-crud.sh Product Catalog \
  'name:string:required|searchable,price:decimal:required|filterable,description:text:permit_empty,category_id:int:required|filterable' \
  yes
```

The first `make-crud.sh` invocation also patches `app/Config/Routes.php` with a glob-based `api/v1` loader that auto-discovers all files under `Config/Routes/v1/`. Subsequent scaffolds are idempotent — the loader is only added once.

Each invocation also runs `php spark module:check <Resource> --domain <Domain>` automatically (or you can run it yourself):

```
Module bootstrap check passed.
```

**5. The only hand-written code:**

`category_name` on `ProductResponseDTO` and this hook in `ProductService`:

```php
protected function enrichEntities(array $entities): array
{
    return (new RelationLabelLoader())->attachLabel(
        $entities,
        sourceField:  'category_id',
        targetField:  'category_name',
        relatedTable: 'categories',
        relatedLabel: 'name',
    );
}
```

---

## Generated structure

```
app/
├── Config/
│   ├── ApiCoreServices.php            ← core:install
│   ├── CatalogDomainServices.php      ← make-crud (service factories)
│   ├── Routes.php                     ← patched by core:install (/health) + make-crud (api/v1 loader)
│   └── Routes/v1/
│       └── catalog.php                ← make-crud (domain routes)
│
├── Controllers/Api/V1/Catalog/
│   ├── CategoryController.php
│   └── ProductController.php
│
├── DTO/
│   ├── Request/Catalog/
│   │   ├── CategoryCreateRequestDTO.php
│   │   ├── CategoryIndexRequestDTO.php
│   │   ├── CategoryUpdateRequestDTO.php
│   │   ├── ProductCreateRequestDTO.php
│   │   ├── ProductIndexRequestDTO.php
│   │   └── ProductUpdateRequestDTO.php
│   └── Response/Catalog/
│       ├── CategoryResponseDTO.php
│       └── ProductResponseDTO.php     ← + category_name (hand-written)
│
├── Database/Migrations/
│   ├── ..._CreateCategoriesTable.php
│   └── ..._CreateProductsTable.php
│
├── Documentation/Catalog/
│   ├── CategoryEndpoints.php
│   └── ProductEndpoints.php
│
├── Entities/
│   ├── CategoryEntity.php
│   └── ProductEntity.php
│
├── Interfaces/Catalog/
│   ├── CategoryServiceInterface.php
│   └── ProductServiceInterface.php
│
├── Language/{en,es}/
│   ├── Categories.php
│   └── Products.php
│
├── Models/
│   ├── CategoryModel.php
│   └── ProductModel.php
│
└── Services/Catalog/
    ├── CategoryService.php
    └── ProductService.php             ← + enrichEntities() (hand-written)
```

---

## Routes.php after setup

`app/Config/Routes.php` is patched automatically by two commands — no manual edits needed:

```php
// Injected by: php spark core:install
// ci4-api-core: health route start
$routes->get('health', static function () {
    $checker = new \dcardenasl\Ci4ApiCore\Monitoring\HealthChecker();
    $checks  = $checker->checkAll();
    $status  = $checker->getOverallStatus($checks);

    return response()->setJSON([
        'status'    => $status,
        'checks'    => $checks,
        'timestamp' => date('Y-m-d H:i:s'),
    ])->setStatusCode($status === 'unhealthy' ? 503 : 200);
});
// ci4-api-core: health route end

// Injected by: first make-crud.sh invocation
// ci4-api-scaffolding: api/v1 loader start
$routes->group('api/v1', function ($routes) {
    $routesDir = APPPATH . 'Config/Routes/v1';
    if (is_dir($routesDir)) {
        foreach (glob($routesDir . '/*.php') as $file) {
            if (basename($file) === 'system.php') {
                continue;
            }
            require $file;
        }
    }
});
// ci4-api-scaffolding: api/v1 loader end
```

Both patches are idempotent — re-running the commands leaves `Routes.php` unchanged.

---

## Commit history

| Commit | What it represents |
|--------|--------------------|
| `chore: scaffold ci4 project with codeigniter4/appstarter` | Blank CI4 project — `composer create-project codeigniter4/appstarter` (v4.7.2) |
| `feat: install and wire dcardenasl/ci4-api-core` | `composer require ^0.5` + `php spark core:install` |
| `feat: install dcardenasl/ci4-api-scaffolding` | `composer require --dev ^0.3` |
| `feat: scaffold categories crud with make-crud` | Full scaffold output for Category in Catalog domain |
| `feat: scaffold products crud with make-crud` | Full scaffold output for Product in Catalog domain |
| `feat: enrich products with category name via RelationLabelLoader` | Only hand-written code in this repo |
| `docs: add README and env example` | This file |

---

## Requirements

- PHP 8.2+
- MySQL 8+ (or MariaDB 10.6+)
- Composer 2.x

## Quick start

```bash
cp .env.example .env
# Edit .env: set database credentials
php spark migrate
php spark serve
curl http://localhost:8080/health
curl http://localhost:8080/api/v1/catalog/categories
curl http://localhost:8080/api/v1/catalog/products
```
