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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    $role = App\Models\Role::inRandomOrder()->first();
    $country = App\Models\Country::inRandomOrder()->first();
    $tenant = (app()->environment() == 'testing') ? 'demo' : tenant();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile' => '01094743070',
        'password' => bcrypt($tenant . '@12345'), // secret
        'role_id' => NULL,
        'country_id' => $role->id,
        'currency_id' => 1,
        'language' => 'en',
        'confirmed' => 1,
        'is_active' => 1,
        'created_by' => $user->id,
    ];
});
