<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('categories')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE categories AUTO_INCREMENT = 1");
        }
        insertDefaultCategories();
    }

}
