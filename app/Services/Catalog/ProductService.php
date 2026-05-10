<?php

declare(strict_types=1);

namespace App\Services\Catalog;

use dcardenasl\Ci4ApiCore\Repositories\RepositoryInterface;
use dcardenasl\Ci4ApiCore\Mappers\ResponseMapperInterface;
use App\Interfaces\Catalog\ProductServiceInterface;
use dcardenasl\Ci4ApiCore\Services\BaseCrudService;
use dcardenasl\Ci4ApiCore\Support\RelationLabelLoader;

class ProductService extends BaseCrudService implements ProductServiceInterface
{
    public function __construct(
        RepositoryInterface $productRepository,
        ResponseMapperInterface $responseMapper
    ) {
        parent::__construct($productRepository, $responseMapper);
    }

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
}
