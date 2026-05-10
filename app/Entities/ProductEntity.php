<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use dcardenasl\Ci4ApiCore\DataCasts\DecimalCast;

class ProductEntity extends Entity
{
    protected $castHandlers = [
        'decimal' => DecimalCast::class,
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'decimal',
        'description' => 'string',
        'category_id' => 'int',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
