<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE roles AUTO_INCREMENT = 1");
        }
        insertDefaultRoles();
    }

}
