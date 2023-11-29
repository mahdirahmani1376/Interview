<?php

namespace App\Actions\Product;

use App\Models\Product;

class DeleteProductAction
{
    public function execute(Product $product)
    {
        $product->delete();
    }
}
