<?php

use Illuminate\Database\Seeder;

class BasicSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        configureUploads();
        $this->call(CountriesSeeder::class);
        $this->call(CurrenciesSeeder::class);
        ///////////////////////////////////////////////////////////////// Default Configs
        DB::table('configs')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE configs AUTO_INCREMENT = 1");
        }
        insertDefaultConfigs();
        ////////////////////////////////////////////////////////// insert default role
        DB::table('roles')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE roles AUTO_INCREMENT = 1");
        }
        insertDefaultRoles();
        //////////////////////////////////////////////////// Insert users
        DB::table('users')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
        }
        insertDefaultUsers();
        //////////////////////////////////////////////////////////
        DB::table('sections')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE sections AUTO_INCREMENT = 1");
        }
        insertDefaultSections();

        //////////////////////////////////////////////////////////
        DB::table('categories')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE categories AUTO_INCREMENT = 1");
        }
        insertDefaultCategories();
    }

}
