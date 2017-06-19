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

$factory->define(App\Models\Artist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'active' => $faker->boolean,
        'created_at' => $faker->dateTime
    ];
});

$factory->define(App\Models\Album::class, function (Faker\Generator $faker) {
    return [
        'artist_id' => $faker->numberBetween(1,20),
        'title' => $faker->text(40),
        'released' => $faker->dateTimeThisCentury,
        'active' => $faker->boolean,
        'created_at' => $faker->dateTime
    ];
});

$factory->define(App\Models\Song::class, function (Faker\Generator $faker) {
    return [
        'track' => $faker->numberBetween(1,12),
        'title' => $faker->realText(80),
        'album_id' => $faker->numberBetween(1,60),
        'active' => $faker->boolean,
        'created_at' => $faker->dateTime
    ];
});