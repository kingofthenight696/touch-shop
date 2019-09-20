<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker, $attributes) {

    $title = $faker->sentence(random_int(2, 5));

    return [
        'coordinates' => json_encode([
            'top' =>  random_int(1, 99),
            'left' => random_int(1, 99),
            'width' => random_int(1, 99),
            'height' => random_int(1, 99)
        ], true),
        'title' => $title,
        'description' => $faker->sentence(random_int(1, 5)),
        'price' => random_int(50, 99999),
        'board_id' => $attributes['board_id'],
    ];
});
