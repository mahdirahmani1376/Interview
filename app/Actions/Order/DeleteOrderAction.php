<?php

namespace App\Actions\Order;

use App\Data\OrderData;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;

class DeleteOrderAction
{
    public function execute(Order $order): Order
    {
        $order->delete();
    }
}
