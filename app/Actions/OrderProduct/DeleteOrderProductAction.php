<?php

namespace App\Actions\OrderProduct;

use App\Models\OrderProduct;

class DeleteOrderProductAction
{
    public function execute(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
    }
}
