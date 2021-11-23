<?php

use Illuminate\Database\Seeder;

class CartSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('cart')) {
            DB::table('cart')->delete();
            if (app()->environment() != 'testing') {
                DB::statement("ALTER TABLE cart AUTO_INCREMENT = 1");
            }
            $users = \App\Models\User::get();
            if ($users) {
                foreach ($users as $user) {
                    $products = \App\Models\Product::active()->inRandomOrder()->take(rand(3, 5))->get();
                    if ($products) {
                        foreach ($products as $product) {
                            \App\Models\Cart::create([
                                'created_by' => $user->id,
                                'product_id' => $product->id,
                                'quantity' => 1
                            ]);
                        }
                    }
                }
            }
        }
    }

}
