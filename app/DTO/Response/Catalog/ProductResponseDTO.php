<?php

declare(strict_types=1);

namespace App\DTO\Response\Catalog;

use dcardenasl\Ci4ApiCore\Dto\DataTransferObjectInterface;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductResponse',
    title: 'Product Response',
    required: ["id","name","price","category_id"]
)]
final readonly class ProductResponseDTO implements DataTransferObjectInterface
{
    public function __construct(
        #[OA\Property(description: 'Unique identifier', example: 1)]
        public int $id,
        #[OA\Property(description: 'name', type: 'string')]
        public string $name,
        #[OA\Property(description: 'price', type: 'number', format: 'float')]
        public float $price,
        #[OA\Property(description: 'description', type: 'string')]
        public string $description,
        #[OA\Property(description: 'category_id', type: 'integer')]
        public int $category_id,
        #[OA\Property(description: 'category_name', type: 'string', nullable: true)]
        public ?string $category_name = null,
        #[OA\Property(property: 'created_at', description: 'Creation timestamp', example: '2026-02-26 12:00:00', nullable: true)]
        public ?string $createdAt = null,
        #[OA\Property(property: 'updated_at', description: 'Last update timestamp', example: '2026-02-26 12:00:00', nullable: true)]
        public ?string $updatedAt = null
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            price: (float) ($data['price'] ?? 0),
            description: (string) ($data['description'] ?? ''),
            category_id: (int) ($data['category_id'] ?? 0),
            category_name: $data['category_name'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'category_name' => $this->category_name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
