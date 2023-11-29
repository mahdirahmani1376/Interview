<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasFactory;
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'price',
        'inventory',
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

}
