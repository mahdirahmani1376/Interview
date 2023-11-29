<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        return [
            'order_product_id' => $this->faker->randomNumber(),
            'quantity' => rand(1, 100),
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
        ];
    }
}
