<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartStoreTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $response = $this->json('POST', 'api/cart');

        $response->assertStatus(401);
    }

    public function test_it_adds_valid_data_to_the_cart()
    {
        $product = factory(ProductVariation::class)->create();

        $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart', [
            'products' => [
                ['id' => $product->id, 'quantity' => 2]
            ],
        ]);

        $this->assertDatabaseHas('user_cart', [
            'product_variation_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_it_requires_products_to_be_an_array()
    {
        $response = $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart', [
            'products' => "string",
        ]);

        $response->assertJsonValidationErrors(['products']);
    }

    public function test_it_requires_valid_product_ids()
    {
        $response = $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart', [
            'products' => [
                ['id' => null],
                ['id' => 456],
            ],
        ]);

        $response->assertJsonValidationErrors([
            'products.0.id',
            'products.1.id',
        ]);
    }

    public function test_it_requires_valid_quantity()
    {
        $response = $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart', [
            'products' => [
                ['quantity' => null],
                ['quantity' => 0],
                ['quantity' => -1],
            ],
        ]);

        $response->assertJsonValidationErrors([
            'products.0.quantity',
            'products.1.quantity',
            'products.2.quantity',
        ]);
    }
}
