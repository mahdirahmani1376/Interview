<?php

namespace Tests\Feature;

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BaseTestCase;
use Tests\TestCase;

class OrderProductControllerTest extends BaseTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_user_view_order_products()
    {
        $orderProduct = OrderProduct::factory()->create();

        $response = $this->getJson(route('order-products.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_user_create_order_products(): void
    {
        $product = Product::factory()->create();
        $data = [
          	'product_id' => $product->product_id,
            'quantity' => $quantity = 1,
        ];

        $response = $this->postJson(route('order-products.store'),$data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('order_products',[
            'product_id' => $product->product_id,
            'quantity' => $quantity,
        ]);

    }
}
