<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductScopingTest extends TestCase
{
    public function test_it_can_scope_by_category()
    {
        $products = factory(Product::class, 10)->create();

        $category = factory(Category::class)->create();

        foreach ($products->take(5) as $product) {
            $product->categories()->save($category);
        }

        $response = $this->json('GET', "api/products?category={$category->slug}");

        $response->assertJsonCount(5, 'payload');
    }
}
