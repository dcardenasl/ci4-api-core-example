<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\ProductEntity;
use dcardenasl\Ci4ApiCore\Models\BaseAuditableModel;
use dcardenasl\Ci4ApiCore\Models\Traits\Filterable;
use dcardenasl\Ci4ApiCore\Models\Traits\Searchable;

class ProductModel extends BaseAuditableModel
{
    use Filterable;
    use Searchable;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $returnType = ProductEntity::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ['name', 'price', 'description', 'category_id'];

    /** @var array<int, string> */
    protected array $searchableFields = ['name'];

    /** @var array<int, string> */
    protected array $filterableFields = ['id', 'price', 'category_id'];

    /** @var array<int, string> */
    protected array $sortableFields = ['id', 'created_at', 'name', 'price', 'category_id'];

    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'price' => 'required|decimal',
        'description' => 'permit_empty|string',
        'category_id' => 'required|integer',
    ];
}
