<?php

use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (app()->environment() != 'production') {
            \DB::table('messages')->delete();
            if (app()->environment() != 'testing') {
                \DB::statement("ALTER TABLE messages AUTO_INCREMENT = 1");
            }
            factory(App\Models\Message::class, 5)->create();
        }
    }

}
