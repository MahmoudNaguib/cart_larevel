<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
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
$factory->define(\App\Models\Favourite::class, function (Faker $faker) {
    $user = App\Models\User::active()->inRandomOrder()->first();
    $product = App\Models\Product::inRandomOrder()->first();
    return [
        'product_id' => $product->id,
        'created_by' => $user->id,
    ];
});
