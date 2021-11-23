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
$factory->define(App\Models\Role::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    $permissions = permissions();
    shuffle($permissions);
    $randomPermissions = array_slice($permissions, 0, rand(1, sizeof($permissions) - 1));
    return [
        'title' => $faker->name,
        'permissions' => $randomPermissions,
        'created_by' => $user->id
    ];
});
