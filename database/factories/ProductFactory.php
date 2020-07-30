<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'EAN' => $faker->ean13,
        'type' => $faker->words(2, true),
        'weight' => $faker->randomFloat($nbMaxDecimals = 3, $min = 0.2, $max = 5),
        'color' => $faker->hexColor,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'price' => $faker->numberBetween($min = 1, $max = 1000),
        'quantity' => $faker->numberBetween($min = 1, $max = 30),
    ];
});
