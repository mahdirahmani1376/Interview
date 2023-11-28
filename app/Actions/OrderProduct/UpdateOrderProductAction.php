<?php

namespace App\Actions\OrderProduct;

use App\Data\OrderProductData;
use App\Exceptions\MessageException;
use App\Models\OrderProduct;
use App\Models\User;

class UpdateOrderProductAction
{
    public function execute(OrderProductData $orderProductData,OrderProduct $orderProduct)
    {
        $product = $orderProductData->product();
        $inventory = $product->inventory;
        if ($inventory < $orderProductData->quantity) {
            throw new MessageException(trans('messages.product_has_insufficient_quantity'));
        }

        $orderProduct->update([
            'product_id' => $product->product_id,
            'quantity' => $orderProductData->quantity
        ]);

        return $orderProduct;
    }
}
