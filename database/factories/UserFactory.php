<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker, $attributes) {

    return [
        'name' => $attributes['name'] ?? $faker->name,
        'role_id' => $attrib['role_id'] ?? Role::where('name', Role::ADMIN_ROLE)->first()->id,
        'email' => $attributes['email'] ?? $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $attributes['password'] ?? bcrypt(config('credentials.test-admin.password')),
        'remember_token' => Str::random(10),
    ];
});
