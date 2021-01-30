<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use App\Models\Category;

class CategoryIndexTest extends TestCase
{
    public function test_it_returns_a_collection_of_categories()
    {
        $categories = factory(Category::class, 5)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                'slug' => $category->slug,
            ]);
        });
    }

    public function test_it_returns_parents_only()
    {
        $category = factory(Category::class)->create();

        $response = $this->json('GET', 'api/categories');

        $category->appendNode(
            factory(Category::class)->create()
        );

        $response->assertJsonCount(1, 'payload');
    }

    public function test_it_returns_categories_by_order()
    {
        $instance_one = factory(Category::class)->create([
            'order' => 2,
        ]);

        $instance_two = factory(Category::class)->create([
            'order' => 1,
        ]);

        $response = $this->json('GET', 'api/categories');

        $response->assertSeeInOrder([
            $instance_two->slug,
            $instance_one->slug,
        ]);
    }
}
