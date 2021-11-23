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
$factory->define(\App\Models\Voucher::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    return [
        'code' => RandomString(5),
        'currency_id'=>env('DEFAULT_CURRENCY',1),
        'amount' => rand(10, 50),
        'expiry_date' => date('Y-m-d', strtotime(date("Y-m-d", strtotime("tomorrow")) . ' + ' . rand(5, 100) . ' days')),
        'max_usage' => rand(100, 1000),
        'used' => 0,
        'created_by' => $user->id,
    ];
});
