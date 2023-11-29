<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends BaseModel
{
    use HasFactory;

    protected $primaryKey = 'order_product_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected function itemPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->quantity * $this->product->price,
        );
    }
}
