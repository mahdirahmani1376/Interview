<?php

namespace App\Http\Controllers;

use App\Actions\Order\DeleteOrderAction;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     operationId="indexOrders",
     *     tags={"Auth"},
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function index(): JsonResponse
    {
        return Response::success(
            data: OrderResource::collection(
                Order::with('user', 'orderProducts')->get()
            )
        );
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{order}",
     *     operationId="indexOrders",
     *     tags={"Auth"},
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function show(Order $order): JsonResponse
    {
        return OrderResource::make($order->load('orderProducts', 'user'));
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{order}",
     *     operationId="deleteOrders",
     *     tags={"Auth"},
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function destroy(Order $order, DeleteOrderAction $deleteOrderAction): JsonResponse
    {
        $deleteOrderAction->execute($order);

        return Response::success(
            message: trans('messages.order_deleted_successfully')
        );
    }
}
