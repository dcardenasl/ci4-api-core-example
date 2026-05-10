<?php

declare(strict_types=1);

namespace App\Services\Catalog;

use dcardenasl\Ci4ApiCore\Repositories\RepositoryInterface;
use dcardenasl\Ci4ApiCore\Mappers\ResponseMapperInterface;
use App\Interfaces\Catalog\CategoryServiceInterface;
use dcardenasl\Ci4ApiCore\Services\BaseCrudService;

class CategoryService extends BaseCrudService implements CategoryServiceInterface
{
    public function __construct(
        RepositoryInterface $categoryRepository,
        ResponseMapperInterface $responseMapper
    ) {
        parent::__construct($categoryRepository, $responseMapper);
    }

    /**
     * Domain Hooks
     *
     * Implement beforeStore, afterStore, beforeUpdate, etc.,
     * to add specific business logic while keeping the service layer clean.
     */
}
