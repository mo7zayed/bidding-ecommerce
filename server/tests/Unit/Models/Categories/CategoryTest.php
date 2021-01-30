<?php

namespace Tests\Unit\Models\Categories;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class CategoryTest extends TestCase
{
    public function test_it_has_many_childern()
    {
        $category = factory(Category::class)->create();

        $category->appendNode(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $category->children()->first());
    }

    public function test_it_fetch_parents_only()
    {
        $category = factory(Category::class)->create();

        $category->appendNode(
            factory(Category::class)->create()
        );

        $this->assertEquals(1, $category->whereIsRoot()->count());
    }

    public function test_it_is_ordered_by_number_of_order_field()
    {
        $instance_one = factory(Category::class)->create([
            'order' => 2,
        ]);

        $instance_two = factory(Category::class)->create([
            'order' => 1,
        ]);


        $this->assertNotNull(Category::ordered()->first());

        $this->assertEquals($instance_two->name, Category::ordered()->first()->name);
    }

    public function test_it_has_many_products()
    {
        $category = factory(Category::class)->create();

        $category->products()->save(
            factory(Product::class)->create()
        );

        $this->assertInstanceOf(Product::class, $category->products->first());
    }
}
