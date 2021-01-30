<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;

class ProductsShowTest extends TestCase
{
    /**
     * test_it_fails_if_product_not_found
     *
     * @return void
     */
    public function test_it_fails_if_product_not_found()
    {
        $response = $this->json('GET', 'api/products/dummy-slug');

        $response->assertStatus(404);
    }

    /**
     * test_it_shows_if_product_is_found
     *
     * @return void
     */
    public function test_it_shows_if_product_is_found()
    {
        $product = factory(Product::class)->create();

        $response = $this->json('GET', "api/products/{$product->slug}");

        $response->assertJsonFragment([
            'slug' => $product->slug,
        ]);
    }
}
