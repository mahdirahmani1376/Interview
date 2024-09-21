<?php

namespace App\Actions\Product;

use App\Data\ProductData;
use App\Models\Product;

class UpdateProductAction
{
    public function execute(ProductData $productData, Product $product)
    {
        $product->update([
            'name' => $productData->name,
            'price' => $productData->price,
            'inventory' => $productData->inventory,
        ]);

        return $product;
    }
}
