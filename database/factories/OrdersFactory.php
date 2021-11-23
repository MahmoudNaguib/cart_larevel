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
$factory->define(\App\Models\Cart::class, function (Faker $faker) {
    $user = App\Models\User::active()->inRandomOrder()->first();
    $address = App\Models\Address::where('created_by', $user->id)->inRandomOrder()->first();
    return [
        'full_name'=>'full_address',
        'status' => 'Confirmed',
        'total' => 100,
        'created_by' => $user->id,
        'address_id' => $user->addresses()->first()->id
    ];
});
