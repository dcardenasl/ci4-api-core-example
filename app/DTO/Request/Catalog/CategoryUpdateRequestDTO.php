<?php

declare(strict_types=1);

namespace App\DTO\Request\Catalog;

use dcardenasl\Ci4ApiCore\Dto\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CategoryUpdateRequest')]
readonly class CategoryUpdateRequestDTO extends BaseRequestDTO
{
    #[OA\Property(description: 'name', type: 'string', nullable: true)]
    public ?string $name;

    public function rules(): array
    {
        return [
            'name' => 'permit_empty|string|max_length[255]',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = $data['name'] ?? null;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
        ], fn($v) => $v !== null);
    }
}
