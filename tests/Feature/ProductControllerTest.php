<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\BaseTestCase;

class ProductControllerTest extends BaseTestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_user_view_products()
    {
        Product::factory()->create();

        $response = $this->getJson(route('products.index'));

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.0.product_id')
                ->has('data.0.orderProducts')
                ->etc();
        });
    }

    /** @test */
    public function can_user_view_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', $product));

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($product) {
            $json
                ->where('data.product_id', $product->product_id)
                ->has('data.orderProducts')
                ->etc();
        });

    }

    /** @test */
    public function can_user_create_product()
    {
        $product = Product::factory()->make();

        $response = $this->postJson(route('products.store'), $product->toArray());

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) {
            $json
                ->has('data.product_id')
                ->etc();
        });

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'price' => $product->price,
            'inventory' => $product->inventory,
        ]);
    }

    /** @test */
    public function can_user_update_product()
    {
        $product = Product::factory()->create();

        $data = $product->factory()->make();

        $response = $this->putJson(route('products.update', $product), $data->toArray());

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) use ($data) {
            $json
                ->where('data.name', $data->name)
                ->where('data.price', (string) $data->price)
                ->where('data.inventory', (string) $data->inventory)
                ->etc();
        });
        $this->assertDatabaseHas('products', [
            'product_id' => $product->product_id,
            'name' => $data->name,
            'price' => $data->price,
            'inventory' => $data->inventory,
        ]);
    }

    /** @test */
    public function can_user_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('products.destroy', $product));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', [
            'product_id' => $product->product_id,
        ]);
    }
}
