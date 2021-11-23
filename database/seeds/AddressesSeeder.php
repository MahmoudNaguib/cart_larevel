<?php

use Illuminate\Database\Seeder;

class AddressesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (\Schema::hasTable('addresses')) {
            DB::table('addresses')->delete();
            if (app()->environment() != 'testing') {
                DB::statement("ALTER TABLE addresses AUTO_INCREMENT = 1");
            }
            $users = App\Models\User::get();
            if ($users) {
                foreach ($users as $user) {
                    factory(\App\Models\Address::class)->create(['created_by' => $user->id]);
                }
            }
        }
    }

}
