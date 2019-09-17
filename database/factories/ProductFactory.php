<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker, $attributes) {

    $title = $faker->sentence(random_int(2, 5));

    //TODO add coordinates format

    return [
        'coordinates' => $attributes['coordinates'] ?? '',
        'title' => $title,
        'description' => $faker->paragraph(random_int(2, 10)),
        'price' => random_int(50, 99999),
        'board_id' => $attributes['board_id'],
    ];
});
