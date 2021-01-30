<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartUpdateTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $product = factory(ProductVariation::class)->create();

        $response = $this->json('PATCH', "api/cart/{$product->id}");

        $response->assertStatus(401);
    }

    public function test_it_fails_if_product_not_found()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'PATCH', "api/cart/" . rand(999, 9999), [
            'quantity' => 5
        ]);

        $response->assertStatus(404);
    }

    public function test_it_updates_the_cart()
    {
        $product = factory(ProductVariation::class)->create();

        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product,
            [
                'quantity' => 1
            ]
        );

        $this->jsonAs($user, 'PATCH', "api/cart/{$product->id}", [
            'quantity' => 5
        ]);

        $this->assertDatabaseHas('user_cart', [
            'product_variation_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    public function test_it_requires_valid_quantity()
    {
        $product = factory(ProductVariation::class)->create();

        $response = $this->jsonAs(factory(User::class)->create(), 'PATCH', "api/cart/{$product->id}", [
            'quantity' => null
        ]);

        $response->assertJsonValidationErrors([
            'quantity',
        ]);

        $response = $this->jsonAs(factory(User::class)->create(), 'PATCH', "api/cart/{$product->id}", [
            'quantity' => "Test"
        ]);

        $response->assertJsonValidationErrors([
            'quantity',
        ]);
    }
}
