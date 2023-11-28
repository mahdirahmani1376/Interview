<?php

namespace App\Http\Controllers;

use App\Actions\Product\CreateProductAction;
use App\Actions\Product\UpdateProductAction;
use App\Data\ProductData;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function index()
    {
        return Response::success(
            data: ProductResource::collection(
                Product::with([
                    'orderProduct' => [
                        'order'
                    ]
                ])->get()
            )
        );
    }

    public function store(ProductData $productData, CreateProductAction $createProductAction)
    {
        $product = $createProductAction->execute($productData);

        return Response::success(
          data: ProductResource::make($product)
        );
    }

    public function show(Product $product)
    {
        return Response::success(
          data: ProductResource::make($product->load('orderProduct'))
        );
    }

    public function update(ProductData $productData,UpdateProductAction $updateProductAction)
    {
        $product = $updateProductAction->execute($productData);

        return Response::success(
          data: ProductResource::make($product)
        );
    }

    public function destroy(Product $product)
    {
        return Response::success(
          message: trans('messages.product_deleted_successfully')
        );
    }



}
