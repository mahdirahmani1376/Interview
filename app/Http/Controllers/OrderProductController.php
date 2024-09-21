<?php

namespace App\Http\Controllers;

use App\Actions\OrderProduct\CreateOrderProductAction;
use App\Actions\OrderProduct\DeleteOrderProductAction;
use App\Actions\OrderProduct\UpdateOrderProductAction;
use App\Data\OrderProductData;
use App\Http\Resources\OrderProductResource;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Response;

class OrderProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/order-products",
     *     operationId="indexOrderProducts",
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function index()
    {
        return Response::success(
            data: OrderProductResource::collection(
                OrderProduct::with([
                    'product',
                    'order' => [
                        'user',
                    ],
                ])->get()
            )
        );
    }

    /**
     * @OA\Get(
     *     path="/api/order-products/{orderProduct}",
     *     operationId="indexOrderProducts",
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function show(OrderProduct $orderProduct)
    {
        return Response::success(
            data: OrderProductResource::make($orderProduct->load([
                'product',
                'order' => [
                    'user',
                ],
            ]))
        );
    }

    /**
     * @OA\Post(
     *     path="/api/order-products",
     *     operationId="storeOrderProducts",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="product_id", type="string", description="Product_id", example="1"),
     *              @OA\Property(property="quantity", type="string", description="quantity", example="1"),
     *          )
     *      ),
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function store(OrderProductData $orderProductData, CreateOrderProductAction $createOrderProductAction)
    {
        $orderProduct = $createOrderProductAction->execute($orderProductData, auth()->user());

        return Response::success(
            data: OrderProductResource::make($orderProduct)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/order-products/{orderProduct}",
     *     operationId="updateOrderProducts",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="product_id", type="string", description="Product_id", example="1"),
     *              @OA\Property(property="quantity", type="string", description="quantity", example="1"),
     *          )
     *      ),
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function update(OrderProductData $orderProductData, OrderProduct $orderProduct, UpdateOrderProductAction $updateOrderProductAction)
    {
        $orderProduct = $updateOrderProductAction->execute($orderProductData, $orderProduct);

        return Response::success(
            data: OrderProductResource::make($orderProduct)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/order-products/{orderProduct}",
     *     operationId="deleteOrderProducts",
     *     tags={"Auth"},
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function destroy(OrderProduct $orderProduct, DeleteOrderProductAction $deleteOrderProductAction)
    {
        $deleteOrderProductAction->execute($orderProduct);

        return Response::success(
            message: trans('messages.order_product_deleted_successfully')
        );
    }
}
