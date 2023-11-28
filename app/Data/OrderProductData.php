<?php

namespace App\Data;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class OrderProductData extends Data
{
    public function __construct(
        public int $product_id,
        public int $quantity
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'product_id' => ['required',Rule::exists('products','product_id')],
            'quantity' => ['required', 'numeric', 'min:1', 'max:1000000'],
        ];
    }

    public function product(): ?Product
    {
        return Product::find($this->product_id);
    }
}
