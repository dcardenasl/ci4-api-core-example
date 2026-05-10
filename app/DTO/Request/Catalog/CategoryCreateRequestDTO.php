<?php

declare(strict_types=1);

namespace App\DTO\Request\Catalog;

use dcardenasl\Ci4ApiCore\Dto\BaseRequestDTO;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CategoryCreateRequest')]
readonly class CategoryCreateRequestDTO extends BaseRequestDTO
{
    #[OA\Property(description: 'name', type: 'string')]
    public string $name;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max_length[255]',
        ];
    }

    protected function map(array $data): void
    {
        $this->name = (string) ($data['name'] ?? '');
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
