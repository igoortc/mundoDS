<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Show::class, function (Faker\Generator $faker) {
    $user = \App\User::inRandomOrder()->first();
    
    return [
        'name' => $faker->name,
        'poster' => $faker->imageUrl,
        'synopsis' => $faker->sentence ,
        'seasons' => $faker->randomDigit ,
        'status' => $faker->randomLetter,
        'netflix' => $faker->url,
        'imdb' => $faker->url
    ];
});
