<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\OrderProduct */
class OrderProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_product_id' => $this->order_product_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'product_id' => $this->product_id,
            'order_id' => $this->order_id,

            'Product' => new ProductResource($this->whenLoaded('Product')),
        ];
    }
}
