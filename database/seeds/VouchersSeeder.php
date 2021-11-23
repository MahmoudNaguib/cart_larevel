<?php

use Illuminate\Database\Seeder;

class VouchersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (app()->environment() != 'production') {
            \DB::table('vouchers')->delete();
            if (app()->environment() != 'testing') {
                \DB::statement("ALTER TABLE vouchers AUTO_INCREMENT = 1");
            }
            factory(App\Models\Voucher::class, 5)->create();
        }
    }

}
