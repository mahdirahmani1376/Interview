<?php

namespace App\Http\Controllers;

use App\Actions\Product\CreateProductAction;
use App\Actions\Product\DeleteProductAction;
use App\Actions\Product\UpdateProductAction;
use App\Data\ProductData;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="indexProducts",
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function index()
    {
        return Response::success(
            data: ProductResource::collection(
                Product::with([
                    'products' => [
                        'order',
                    ],
                ])->get()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     operationId="storeProducts",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="product_name", example="test"),
     *              @OA\Property(property="price", type="int", description="quantity", example="1"),
     *              @OA\Property(property="inventory", type="int", description="quantity", example="1"),
     *          )
     *      ),
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function store(ProductData $productData, CreateProductAction $createProductAction)
    {
        $product = $createProductAction->execute($productData);

        return Response::success(
            data: ProductResource::make($product)
        );
    }

    /**
     * @OA\Get(
     *     path="/api/products/{product}",
     *     operationId="indexProducts",
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function show(Product $product)
    {
        return Response::success(
            data: ProductResource::make($product->load('products'))
        );
    }

    /**
     * @OA\Put(
     *     path="/api/products/{product_id}",
     *     operationId="storeProducts",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="product_name", example="test"),
     *              @OA\Property(property="price", type="int", description="quantity", example="1"),
     *              @OA\Property(property="inventory", type="int", description="quantity", example="1"),
     *          )
     *      ),
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function update(ProductData $productData, UpdateProductAction $updateProductAction, Product $product)
    {
        $product = $updateProductAction->execute($productData, $product);

        return Response::success(
            data: ProductResource::make($product)
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     operationId="deleteOrderProducts",
     *     tags={"Auth"},
     *     @OA\Response(response=200,description="Success",@OA\JsonContent())),
     *     @OA\Response(response=400,description="Bad Request - Invalid input",@OA\JsonContent()),
     *     @OA\Response(response=401,description="Unauthorized - Authentication failed",@OA\JsonContent())
     * )
     */
    public function destroy(Product $product, DeleteProductAction $deleteProductAction)
    {
        $deleteProductAction->execute($product);

        return Response::success(
            message: trans('messages.product_deleted_successfully')
        );
    }
}
