<?php

namespace App\Http\Controllers;

use App\Actions\OrderProduct\CreateOrderProductAction;
use App\Actions\OrderProduct\DeleteOrderProductAction;
use App\Actions\OrderProduct\UpdateOrderProductAction;
use App\Data\OrderProductData;
use App\Http\Resources\OrderProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Response;

class OrderProductController extends Controller
{
    public function index()
    {
        return Response::success(
            data: OrderProductResource::collection(
                OrderProduct::with([
                    'product',
                    'order' => [
                        'user'
                    ]
                ])->get()
            )
        );
    }

    public function show(OrderProduct $orderProduct)
    {
        return Response::success(
          data: OrderProductResource::make($orderProduct->load([
                'product',
                'order' => [
                    'user'
                ]
          ]))
        );
    }

    public function store(OrderProductData $orderProductData,CreateOrderProductAction $createOrderProductAction)
    {
        $orderProduct = $createOrderProductAction->execute($orderProductData,auth()->user());

        return Response::success(
            data: OrderProductResource::make($orderProduct)
        );
    }

    public function update(OrderProductData $orderProductData,OrderProduct $orderProduct,UpdateOrderProductAction $updateOrderProductAction)
    {
        $orderProduct = $updateOrderProductAction->execute($orderProductData,$orderProduct);

        return Response::success(
            data: OrderProductResource::make($orderProduct)
        );
    }

    public function destroy(OrderProduct $orderProduct,DeleteOrderProductAction $deleteOrderProductAction)
    {
        $deleteOrderProductAction->execute($orderProduct);

        return Response::success(
           message: trans('messages.order_product_deleted_successfully')
        );
    }
}
