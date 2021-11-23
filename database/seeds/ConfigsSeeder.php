<?php

use Illuminate\Database\Seeder;

class ConfigsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \Cache::forget('configs');
        \DB::table('configs')->delete();
        if (app()->environment() != 'testing') {
            \DB::statement("ALTER TABLE configs AUTO_INCREMENT = 1");
        }
        insertDefaultConfigs();
    }

}
