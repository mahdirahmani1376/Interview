<?php

namespace App\Observers;

use App\Mail\NotifyManagerMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    public function created(Product $product): void
    {
        $manager = User::where([
            'email' => 'manager@test.com'
        ])->first();

        if ($manager) {
            Mail::to($manager)->send(new NotifyManagerMail($product));
        }

    }
    public function deleted(Product $product)
    {
        $product->orderProducts()->delete();
    }
}
