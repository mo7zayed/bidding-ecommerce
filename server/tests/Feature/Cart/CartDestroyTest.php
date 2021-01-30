<?php

namespace Tests\Feature\Cart;

use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartDestroyTest extends TestCase
{
    public function test_user_must_be_logged_in()
    {
        $response = $this->json('DELETE', 'api/cart/1');

        $response->assertStatus(401);
    }

    public function test_it_fails_if_product_not_found()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user, 'DELETE', "api/cart/" . rand(999, 9999));

        $response->assertStatus(404);
    }

    public function test_it_deletes_data_from_the_cart()
    {
        $product = factory(ProductVariation::class)->create();

        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product,
            [
                'quantity' => 1
            ]
        );

        $this->jsonAs($user, 'DELETE', "api/cart/$product->id");

        $this->assertDatabaseMissing('user_cart', [
            'product_variation_id' => $product->id,
            'quantity' => 1,
        ]);
    }
}
