<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PriceQuantityHistory;
use Faker\Generator as Faker;

$factory->define(PriceQuantityHistory::class, function (Faker $faker) {
    return [
        'product_id' => $faker->randomDigit,
        'price' => $faker->numberBetween($min = 1, $max = 1000),
        'quantity' => $faker->numberBetween($min = 1, $max = 30),
        'updated_at' => $faker->dateTimeThisMonth()
    ];
});
