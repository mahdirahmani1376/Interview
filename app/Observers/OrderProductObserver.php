<?php

namespace App\Observers;

use App\Exceptions\MessageException;
use App\Models\OrderProduct;

class OrderProductObserver
{
    public function created(OrderProduct $orderProduct): void
    {
        $orderProduct->product->inventory->decrement($orderProduct->quantity);
    }

    public function updated(OrderProduct $orderProduct): void
    {
    }

    public function deleted(OrderProduct $orderProduct): void
    {
        $orderProduct->product->inventory->increment($orderProduct->quantity);
    }

}
