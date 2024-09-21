<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\User;
use App\Mail\NotifyManagerMail;
class ProductObserver
{
    public function created(Product $product): void
    {
        $manager = User::query()->where([
            'email' => 'manager@test.com'
        ])->first();
        NotifyManagerMail::send();

    }
    public function deleted(Product $product)
    {
        $product->orderProducts()->delete();
    }
}
