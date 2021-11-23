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
$factory->define(App\Models\Config::class, function (Faker $faker) {
    $record = $faker->sentence(3);
    return [
        'field_type' => 'text',
        'field_class' => NULL,
        'type' => 'Basic Information',
        'field' => 'field_' .rand(1,1000),
        'label' => NULL,
        'value' => $record,
        'created_by' => 1,
    ];
});
