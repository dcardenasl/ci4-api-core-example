<?php

declare(strict_types=1);

namespace App\DTO\Request\Catalog;

use dcardenasl\Ci4ApiCore\Dto\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ProductCreateRequest')]
readonly class ProductCreateRequestDTO extends BaseRequestDTO
{
    #[OA\Property(description: 'name', type: 'string')]
    public string $name;
    #[OA\Property(description: 'price', type: 'number', format: 'float')]
    public float $price;
    #[OA\Property(description: 'description', type: 'string')]
    public string $description;
    #[OA\Property(description: 'category_id', type: 'integer')]
    public int $category_id;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max_length[255]',
            'price' => 'required|decimal',
            'description' => 'permit_empty|string',
            'category_id' => 'required|integer',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = (string) ($data['name'] ?? '');
        $this->price = (float) ($data['price'] ?? 0);
        $this->description = (string) ($data['description'] ?? '');
        $this->category_id = (int) ($data['category_id'] ?? 0);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];
    }
}
