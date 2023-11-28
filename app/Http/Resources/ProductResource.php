<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'inventory' => $this->inventory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'orderProducts' => OrderProductResource::collection($this->whenLoaded('orderProducts'))
        ];
    }
}
