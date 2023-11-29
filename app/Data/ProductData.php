<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ProductData extends Data
{
    public function __construct(
        public string $name,
        public string $price,
        public string $inventory
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'gte:0'],
            'inventory' => ['required', 'integer', 'gte:0'],
        ];
    }
}
