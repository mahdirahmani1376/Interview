<?php

namespace App\Actions\Order;

use App\Models\Order;

class DeleteOrderAction
{
    public function execute(Order $order): Order
    {
        $order->delete();
    }
}
