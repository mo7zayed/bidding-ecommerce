<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    public function test_it_returns_a_collection_of_products()
    {
        $products = factory(Product::class, 5)->create();

        $response = $this->json('GET', 'api/products');

        $products->each(function ($product) use ($response) {
            $response->assertJsonFragment([
                'slug' => $product->slug,
            ]);
        });
    }
}
