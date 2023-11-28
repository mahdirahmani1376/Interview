<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'price',
        'inventory',
    ];

    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class,'product_id');
    }

}
