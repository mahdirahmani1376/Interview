<?php

namespace App\Http\Controllers;

use App\Actions\Order\DeleteOrderAction;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::success(
            data: OrderResource::collection(
                Order::with('user', 'orderProducts')->get()
            )
        );
    }

    public function show(Order $order): JsonResponse
    {
        return OrderResource::make($order->load('orderProducts', 'user'));
    }

    public function destroy(Order $order, DeleteOrderAction $deleteOrderAction): JsonResponse
    {
        $deleteOrderAction->execute($order);

        return Response::success(
            message: trans('messages.order_deleted_successfully')
        );
    }
}
