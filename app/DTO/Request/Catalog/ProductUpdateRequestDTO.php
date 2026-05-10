<?php

declare(strict_types=1);

namespace App\DTO\Request\Catalog;

use dcardenasl\Ci4ApiCore\Dto\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ProductUpdateRequest')]
readonly class ProductUpdateRequestDTO extends BaseRequestDTO
{
    #[OA\Property(description: 'name', type: 'string', nullable: true)]
    public ?string $name;
    #[OA\Property(description: 'price', type: 'number', format: 'float', nullable: true)]
    public ?float $price;
    #[OA\Property(description: 'description', type: 'string', nullable: true)]
    public ?string $description;
    #[OA\Property(description: 'category_id', type: 'integer', nullable: true)]
    public ?int $category_id;

    public function rules(): array
    {
        return [
            'name' => 'permit_empty|string|max_length[255]',
            'price' => 'permit_empty|decimal',
            'description' => 'permit_empty|string',
            'category_id' => 'permit_empty|integer',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = $data['name'] ?? null;
        $this->price = isset($data['price']) ? (float) $data['price'] : null;
        $this->description = $data['description'] ?? null;
        $this->category_id = isset($data['category_id']) ? (int) $data['category_id'] : null;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ], fn($v) => $v !== null);
    }
}
