<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::where('role', 'admin')->get()->random(),
        'category_id' => \App\Category::all()->random(),
        'name' => $faker->word,
        'price' => $faker->numberBetween(0, 9999.99),
        'stock' => $faker->numberBetween(0, 1000),
        'brand' => $faker->randomElement(['apple', 'samsung', 'oppo', 'xiaomi', 'huawei', 'dell', 'hp']),
        'min_allowed_stock' => $faker->numberBetween(1, 20),
        'description' => $faker->text(500),
        'image' => null,
    ];
});
