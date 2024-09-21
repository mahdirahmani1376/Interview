<?php

namespace App\Observers;

use App\Models\OrderProduct;

class OrderProductObserver
{
    public function created(OrderProduct $orderProduct): void
    {
        $orderProduct->product->decrement('inventory', $orderProduct->quantity);
    }

    public function updated(OrderProduct $orderProduct): void
    {
    }

    public function deleted(OrderProduct $orderProduct): void
    {
        $orderProduct->product->increment('inventory', $orderProduct->quantity);
    }
}
