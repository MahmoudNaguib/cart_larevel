<?php

use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (app()->environment() != 'production') {
            \DB::table('contacts')->delete();
            if (app()->environment() != 'testing') {
                \DB::statement("ALTER TABLE contacts AUTO_INCREMENT = 1");
            }
            factory(App\Models\Contact::class, 5)->create();
        }
    }

}
