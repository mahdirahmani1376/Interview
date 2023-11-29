<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function deleted(Order $order): void
    {
        $order->orderProducts()->delete();
    }
}
