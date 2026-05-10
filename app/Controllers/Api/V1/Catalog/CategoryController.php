<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1\Catalog;

use dcardenasl\Ci4ApiCore\Http\ApiController;
use App\DTO\Request\Catalog\CategoryCreateRequestDTO;
use App\DTO\Request\Catalog\CategoryIndexRequestDTO;
use App\DTO\Request\Catalog\CategoryUpdateRequestDTO;
use App\Interfaces\Catalog\CategoryServiceInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class CategoryController extends ApiController
{
    protected CategoryServiceInterface $categoryService;

    protected function resolveDefaultService(): object
    {
        $this->categoryService = Services::categoryService();

        return $this->categoryService;
    }

    protected array $statusCodes = [
        'store' => 201,
    ];

    public function index(): ResponseInterface
    {
        return $this->handleRequest('index', CategoryIndexRequestDTO::class);
    }

    public function create(): ResponseInterface
    {
        return $this->handleRequest('store', CategoryCreateRequestDTO::class);
    }

    public function update(int $id): ResponseInterface
    {
        return $this->handleRequest(
            fn ($dto, $context) => $this->categoryService->update($id, $dto, $context),
            CategoryUpdateRequestDTO::class
        );
    }

    public function show(int $id): ResponseInterface
    {
        return $this->handleRequest(fn ($dto, $context) => $this->categoryService->show($id, $context));
    }

    public function delete(int $id): ResponseInterface
    {
        return $this->handleRequest(fn ($dto, $context) => $this->categoryService->destroy($id, $context));
    }
}
