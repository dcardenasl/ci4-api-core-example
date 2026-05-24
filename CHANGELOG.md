# Changelog

All notable changes to `dcardenasl/ci4-api-core-example` will be documented here. Format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versioning follows [SemVer](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] — 2026-05-24

Initial release of the reference implementation for `dcardenasl/ci4-api-core` and `dcardenasl/ci4-api-scaffolding`. Each commit in this repo is a discrete, reviewable step from blank project to a fully wired Catalog API.

### Added

- Blank CodeIgniter 4 project via `composer create-project codeigniter4/appstarter` (v4.7.2).
- `dcardenasl/ci4-api-core ^0.7` installed and wired via `php spark core:install` — injects the four required service factories and the `/health` route.
- `dcardenasl/ci4-api-scaffolding ^0.5` installed as `require-dev`.
- **Categories** CRUD module scaffolded via `bash vendor/bin/make-crud.sh Category Catalog 'name:string:required|searchable' yes`.
- **Products** CRUD module scaffolded with a foreign key to Categories: `bash vendor/bin/make-crud.sh Product Catalog 'name:string:required|searchable,price:decimal:required|filterable,description:text:permit_empty,category_id:fk:categories:required|filterable' yes`.
- `RelationLabelLoader` wired into `ProductResponseDTO` to hydrate `category_name` from the Categories table without a dedicated join query.
- CI workflow (`.github/workflows/ci.yml`) running `composer quality` on PHP 8.2 and 8.3.
- GitHub Release workflow (`.github/workflows/release.yml`) triggered on `v*.*.*` tags.
- README with step-by-step walkthrough of every commit and usage instructions.
- `composer.json` metadata: package name `dcardenasl/ci4-api-core-example`, keywords, support links.
- Package constraints updated to `ci4-api-core ^0.7` and `ci4-api-scaffolding ^0.5`.
