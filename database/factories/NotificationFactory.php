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

$factory->define(App\Models\Notification::class, function (Faker $faker) {
    $user = App\Models\User::active()->inRandomOrder()->first();
    $user = \App\Models\User::inRandomOrder()->first();
    return [
        'user_id' => $user->id,
        'title' => $faker->sentence(4),
        'content' => $faker->sentence(10),
        'seen_at' => Null,
    ];
});
