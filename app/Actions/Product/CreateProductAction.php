<?php

namespace App\Actions\Product;

use App\Data\ProductData;
use App\Models\Product;

class CreateProductAction
{
    public function execute(ProductData $productData)
    {
        return Product::create([
            'name' => $productData->name,
            'price' => $productData->price,
            'inventory' => $productData->inventory,
        ]);
    }
}
