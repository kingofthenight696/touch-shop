<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Board;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Board::class, function (Faker $faker, $attributes) {

    $userId = User::adminRole()->first()->id;

    return [
        'image' => $attributes['image'] ?? '',
        'preview' => $attributes['preview'] ?? '',
        'author_id' => $attributes['author_id'] ?? $userId,
        'last_editor_id' => $attributes['last_editor_id'] ?? $userId,
    ];
});
