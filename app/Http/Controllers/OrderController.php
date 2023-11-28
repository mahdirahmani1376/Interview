<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\DeleteOrderAction;
use App\Actions\Order\RemoveItemFromOrderAction;
use App\Data\OrderData;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::success(
          data: OrderResource::collection(
              Order::with('user','orderProducts')->get()
            )
        );
    }

    public function show(Order $order): JsonResponse
    {
        return OrderResource::make($order->load('orderProducts','user'));
    }

    public function destroy(Order $order,DeleteOrderAction $deleteOrderAction): JsonResponse
    {
        $deleteOrderAction->execute($order);

        return Response::success(
          message: trans('messages.order_deleted_successfully')
        );
    }
}
