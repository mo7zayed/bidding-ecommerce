<?php

namespace Tests\Feature\Cart;

use App\Cart\Cart;
use App\Cart\Money;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartIndexTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $response = $this->json('GET', 'api/cart');

        $response->assertStatus(401);
    }

    public function test_it_shows_products_in_user_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
                'quantity' => 1
            ]
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart');

        $response->assertJsonFragment([
            'id' => $product->id
        ]);
    }

    public function test_it_shows_cart_is_empty_when_there_is_no_products()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'GET', 'api/cart');

        $response->assertJsonFragment([
            'is_empty' => true
        ]);
    }

    public function test_it_shows_cart_is_empty_if_sum_of_all_product_quantities_equals_to_zero()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
            'quantity' => 0
        ]
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
            'quantity' => 0
        ]
        );

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
            'quantity' => 0
        ]
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart');

        $response->assertJsonFragment([
            'is_empty' => true
        ]);
    }

    public function test_it_shows_a_formatted_subtotal()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create([
                'price' => 1000
            ]),
            [
            'quantity' => 1
        ]
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart');

        $response->assertJsonFragment([
            'subtotal' => (new Cart($user))->subtotal()->formatted()
        ]);
    }

    public function test_it_can_check_if_the_cart_has_changed_after_syncing()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),
            [
            'quantity' => 10
        ]
        );

        $response = $this->jsonAs($user, 'GET', 'api/cart');

        $response->assertJsonFragment([
            'changed' => true
        ]);
    }
}
