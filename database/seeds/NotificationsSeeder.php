<?php

use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (app()->environment() != 'production') {
            \DB::table('notifications')->delete();
            if (app()->environment() != 'testing') {
                \DB::statement("ALTER TABLE notifications AUTO_INCREMENT = 1");
            }
            $users = App\Models\User::get();
            if ($users) {
                foreach ($users as $user) {
                    factory(\App\Models\Notification::class,5)->create(['user_id' => $user->id]);
                }
            }
        }
    }

}
