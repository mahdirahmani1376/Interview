<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
