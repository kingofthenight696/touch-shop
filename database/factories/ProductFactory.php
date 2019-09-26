<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker, $attributes) {

    $title = $faker->sentence(random_int(2, 5));

    $top = random_int(1, 70);
    $left = random_int(1, 70);
    $width = random_int(1, 3);
    $height = random_int(20, 30);

    return [
        'coordinates' => [
            'top' =>  $top,
            'left' => $left,
            'width' => $width,
            'height' => $height
        ],
        'title' => $title,
        'description' => $faker->sentence(random_int(1, 5)),
        'price' => random_int(50, 99999),
        'board_id' => $attributes['board_id'],
    ];
});
