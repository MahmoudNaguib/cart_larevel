<?php

use Faker\Generator as Faker;

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

$factory->define(App\Models\Country::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    foreach (langs() as $lang) {
        $title[$lang] = $faker->sentence(2);
    }
    return [
        'iso' => str_random(2),
        'title' => $title,
        'created_by' => $user->id
    ];
});
