<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{
    public function test_it_uses_the_slug_as_route_key_name()
    {
        $this->assertEquals('slug', (new Product)->getRouteKeyName());
    }

    public function test_it_has_many_categories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertEquals(2, $product->categories()->count());
    }

    public function test_it_has_many_variations()
    {
        $product = factory(Product::class)->create();

        $product->variations()->save(
            factory(ProductVariation::class)->create([
                'product_id' => $product->id,
            ])
        );

        $product->variations()->save(
            factory(ProductVariation::class)->create([
                'product_id' => $product->id,
            ])
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations()->first());

        $this->assertEquals(2, $product->variations()->count());
    }

    public function test_it_returns_a_money_instance_for_price()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }
    
    public function test_it_returns_a_formatted_price()
    {
        $product = factory(Product::class)->create();

        $this->assertIsString($product->formattedPrice);
    }

    public function test_it_is_in_stock()
    {
        $product = factory(Product::class)->create();

        $this->assertIsString($product->formattedPrice);
    }

    public function test_it_has_stock_information()
    {
        $product = factory(Product::class)->create();

        $product_variation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
        ]);

        $product_variation->stocks()->create([
            'quantity' => 10,
        ]);

        $this->assertInstanceOf(ProductVariation::class, $product_variation->stock()->first());

        $this->assertEquals(10, $product_variation->stockCount());
    }
}
