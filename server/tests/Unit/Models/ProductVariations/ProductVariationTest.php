<?php

namespace Tests\Unit\Models\ProductVariations;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;

class ProductVariationTest extends TestCase
{
    public function test_it_has_one_type()
    {
        $product_variation = factory(ProductVariation::class)->create();

        $this->assertEquals(1, $product_variation->type()->count());
    }

    public function test_it_belongs_to_product()
    {
        $product_variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Product::class, $product_variation->product);
    }

    public function test_it_returns_a_money_instance_for_price()
    {
        $product_variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Money::class, $product_variation->price);
    }

    public function test_it_returns_a_formatted_price()
    {
        $product_variation = factory(ProductVariation::class)->create();

        $this->assertIsString($product_variation->formattedPrice);
    }

    public function test_it_returns_a_product_price_if_variation_price_is_null()
    {
        $product = factory(Product::class)->create();

        $product_variation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'price' => null,
        ]);

        $this->assertEquals($product_variation->price->amount(), $product->price->amount());
    }

    public function test_it_returns_a_product_price_varies()
    {
        $product_variation = factory(ProductVariation::class)->create([
            'price' => 500,
        ]);

        $this->assertTrue($product_variation->isPriceVaries());
    }

    public function test_it_has_many_stocks()
    {
        $product_variation = factory(ProductVariation::class)->create();

        $product_variation->stocks()->create([
            'quantity' => 10,
        ]);

        $this->assertInstanceOf(Stock::class, $product_variation->stocks()->first());
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

        $this->assertEquals(10, $product->stockCount());
    }
}
