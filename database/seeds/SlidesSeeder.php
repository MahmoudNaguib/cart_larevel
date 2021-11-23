<?php

use Illuminate\Database\Seeder;

class SlidesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('slides')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE slides AUTO_INCREMENT = 1");
        }
        factory(App\Models\Slide::class, 5)->create();
    }

}
