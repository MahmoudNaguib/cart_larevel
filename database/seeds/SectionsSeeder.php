<?php

use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('sections')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE sections AUTO_INCREMENT = 1");
        }
        insertDefaultSections();
    }

}
