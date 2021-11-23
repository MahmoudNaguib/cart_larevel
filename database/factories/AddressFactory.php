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

$factory->define(\App\Models\Address::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    $country = App\Models\Country::inRandomOrder()->first();
    return [
        'title'=>'Home Address '.rand(1,1000),
        'country_id' => $country->id,
        'city' => $faker->sentence(2),
        'district' => $faker->sentence(2),
        'zip_code' => rand(1000, 10000),
        'address' => $faker->address,
        'created_by' => $user->id,
    ];
});
