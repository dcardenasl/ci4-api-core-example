<?php

declare(strict_types=1);

namespace Config;

trait CatalogDomainServices
{
    public static function categoryResponseMapper(bool $getShared = true): \dcardenasl\Ci4ApiCore\Mappers\ResponseMapperInterface
    {
        if ($getShared) {
            return static::getSharedInstance('categoryResponseMapper');
        }
        return new \dcardenasl\Ci4ApiCore\Mappers\DtoResponseMapper(\App\DTO\Response\Catalog\CategoryResponseDTO::class);
    }
    public static function categoryService(bool $getShared = true): \App\Interfaces\Catalog\CategoryServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('categoryService');
        }
        return new \App\Services\Catalog\CategoryService(new \dcardenasl\Ci4ApiCore\Repositories\GenericRepository(model(\App\Models\CategoryModel::class)), static::categoryResponseMapper());
    }
    public static function productResponseMapper(bool $getShared = true): \dcardenasl\Ci4ApiCore\Mappers\ResponseMapperInterface
    {
        if ($getShared) {
            return static::getSharedInstance('productResponseMapper');
        }
        return new \dcardenasl\Ci4ApiCore\Mappers\DtoResponseMapper(\App\DTO\Response\Catalog\ProductResponseDTO::class);
    }
    public static function productService(bool $getShared = true): \App\Interfaces\Catalog\ProductServiceInterface
    {
        if ($getShared) {
            return static::getSharedInstance('productService');
        }
        return new \App\Services\Catalog\ProductService(new \dcardenasl\Ci4ApiCore\Repositories\GenericRepository(model(\App\Models\ProductModel::class)), static::productResponseMapper());
    }
}