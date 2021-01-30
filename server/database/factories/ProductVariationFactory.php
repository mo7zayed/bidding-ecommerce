<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Faker\Generator as Faker;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'price' => rand(1000, 9999),
        'product_id' => factory(Product::class)->create()->id,
        'product_variation_type_id' => factory(ProductVariationType::class)->create()->id,
    ];
});
