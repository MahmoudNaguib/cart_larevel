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
$factory->define(App\Models\Slide::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    foreach (langs() as $lang) {
        $title[$lang] = $faker->text(50);
        $content[$lang] = $faker->text(100);
    }
    return [
        'title' => $title,
        'content' => $content,
        'url' => $faker->url,
        'is_active' => 1,
        'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png',['large' => 'crop,1350x390','small' => 'resize,200x120']),
        'created_by' => $user->id,
        'views' => rand(1, 1000),
    ];
});
