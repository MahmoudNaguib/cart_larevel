<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE users AUTO_INCREMENT =1");
        }
        insertDefaultUsers();
    }

}
