<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ReviewsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {
        if (\Schema::hasTable('reviews')) {
            DB::table('reviews')->delete();
            if (app()->environment() != 'testing') {
                DB::statement("ALTER TABLE reviews AUTO_INCREMENT = 1");
            }
            $users = \App\Models\User::get();
            if($users){
                foreach ($users as $user){
                   $orders=\App\Models\Order::where('created_by',$user->id)->get();
                   if($orders){
                       foreach ($orders as $order){
                           if($order->products_list){
                               foreach ($order->products_list as $product){
                                   \App\Models\Review::create([
                                       'created_by' => $user->id,
                                       'product_id' => $product->product_id,
                                       'order_id' => $order->id,
                                       'content' => $faker->text(200),
                                       'rate' => rand(1, 5)
                                   ]);
                               }
                           }
                       }
                   }
                }

            }
        }
    }

}
