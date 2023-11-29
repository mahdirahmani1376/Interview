<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'user_id',
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->orderProducts->sum('item_price'),
        );
    }

    protected function totalCount(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->orderProducts()->count(),
        );
    }
}
