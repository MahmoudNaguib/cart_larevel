<?php

use Illuminate\Database\Seeder;

class FavouritesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('favourites')) {
            DB::table('favourites')->delete();
            if (app()->environment() != 'testing') {
                DB::statement("ALTER TABLE favourites AUTO_INCREMENT = 1");
            }
            $users = \App\Models\User::get();
            if ($users) {
                foreach ($users as $user) {
                    $products = \App\Models\Product::active()->inRandomOrder()->take(rand(1, 10))->get();
                    if ($products) {
                        foreach ($products as $product) {
                            \App\Models\Favourite::create([
                                'created_by' => $user->id,
                                'product_id' => $product->id,
                            ]);
                        }
                    }
                }
            }
        }
    }

}
