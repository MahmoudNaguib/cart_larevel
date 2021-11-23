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
$factory->define(App\Models\Page::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    foreach (langs() as $lang) {
        $title[$lang] = $faker->text(50);
        $slug[$lang] = slug($title[$lang]);
        $content[$lang] = $faker->text(300);
    }
    return [
        'title' => $title,
        'slug' => $slug,
        'content' => $content,
        'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png'),
        'meta_description' => $content,
        'is_active' => 1,
        'created_by' => $user->id,
        'views' => rand(1, 1000),
    ];
});
