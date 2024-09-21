<?php

namespace App\Actions\OrderProduct;

use App\Actions\Order\CreateOrderAction;
use App\Data\OrderProductData;
use App\Exceptions\MessageException;
use App\Models\OrderProduct;
use App\Models\User;

class CreateOrderProductAction
{
    public function __construct(
        public CreateOrderAction $createOrderAction
    ) {
    }

    public function execute(OrderProductData $orderProductData, User $user)
    {
        $product = $orderProductData->product();
        $inventory = $product->inventory;
        if ($inventory < $orderProductData->quantity) {
            throw new MessageException(trans('messages.product_has_insufficient_quantity'));
        }
        $order = $this->createOrderAction->execute($user);

        $orderProduct = OrderProduct::create([
            'order_id' => $order->order_id,
            'product_id' => $product->product_id,
            'quantity' => $orderProductData->quantity,
        ]);

        return $orderProduct;
    }
}
