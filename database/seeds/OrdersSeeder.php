<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('orders')) {
            DB::table('orders')->delete();
            if (app()->environment() != 'testing') {
                DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1");
            }
            $users = \App\Models\User::active()->inRandomOrder()->get();
            if ($users) {
                foreach ($users as $user) {
                    $address = \App\Models\Address::where('created_by', $user->id)->first();
                    if (!$address) {
                        $row = factory(\App\Models\Address::class)->make(['created_by' => $user->id]);
                        $address = \App\Models\Address::create($row->toArray());
                    }
                    for ($i = 0; $i < rand(2, 5); $i++) {
                        $products = \App\Models\Product::active()->inRandomOrder()->take(rand(1, 5))->get();
                        if ($products) {
                            foreach ($products as $product) {
                                \App\Models\Cart::create([
                                    'product_id' => $product->id,
                                    'quantity' => 1,
                                    'created_by' => $user->id
                                ]);
                            }
                        }
                        $order = new \App\Models\Order();
                        $voucher = App\Models\Voucher::inRandomOrder()->first();
                        $order->createOrder($user,['address_id'=>$address->id,'voucher_code'=>@$voucher->code]);
                    }
                }
            }
        }
    }

}
