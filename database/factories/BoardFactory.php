<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Board;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Board::class, function (Faker $faker, $attributes) {

    $user = User::adminRole()->first()->id;

    return [
        'path' => $attributes['path'],
        'author_id' => $attributes['author_id'] ?? $user->id,
        'last_editor_id' => $attributes['last_editor_id'] ?? $user->id,
    ];
});
