<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('currencies')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE currencies AUTO_INCREMENT = 1");
        }
        insertDefaultCurrencies();
    }

}
