<?php

namespace App\Actions\Order;

use App\Exceptions\MessageException;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;

class CreateOrderAction
{
    /**
     * @throws MessageException
     */
    public function execute(User $user): Order
    {
        $order = $user->order;
        if (is_null($user->order)){
            $order = Order::create([
                'user_id' => $user->user_id
            ]);
        }
        return $order;

    }
}
