<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function deleted(Product $product)
    {
        $product->orderProducts()->delete();
    }
}
