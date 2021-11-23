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

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    $category = App\Models\Category::where('top_id', NULL)->inRandomOrder()->first();
    foreach (langs() as $lang) {
        $title[$lang] = $faker->text(25);
    }
    return [
        'top_id' => $category->id,
        'title' => $title,
        'created_by' => $user->id,
    ];
});
