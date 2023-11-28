<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'user_id'
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
