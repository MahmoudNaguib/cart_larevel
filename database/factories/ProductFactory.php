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
$factory->define(App\Models\Product::class, function (Faker $faker) {
    $user = App\Models\User::active()->admin()->inRandomOrder()->first();
    $category = App\Models\Category::active()->whereNUll('top_id')->inRandomOrder()->first();
    foreach (langs() as $lang) {
        $title[$lang] = $faker->text(30);
        $slug[$lang] = slug($title[$lang]);
        $summary[$lang] = $faker->text(100);
        $content[$lang] = $faker->text(300);
    }
    return [
        'category_id' => $category->id,
        'title' => $title,
        'slug' => $slug,
        'content' => $content,
        'summary' => $summary,
        'currency_id' => env('DEFAULT_CURRENCY', 1),
        'price' => rand(100, 1000),
        'discount' => rand(10, 90),
        'image'=>resizeImage(resource_path() . '/imgs/others/'.rand(1,15).'.png'),
        'meta_description' => $content,
        'is_active' => 1,
        'created_by' => $user->id,
        'views' => rand(1, 1000),
    ];
});
