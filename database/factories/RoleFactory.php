<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (
    Faker $faker,
    $attrib = array(
        'name' => null,
    )
) {
    return [
        'name' => $attrib['name'],
    ];
});
