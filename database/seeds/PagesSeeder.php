<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('pages')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE pages AUTO_INCREMENT = 1");
        }
        insertDefaultPages();
    }

}
