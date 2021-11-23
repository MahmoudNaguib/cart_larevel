<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(BasicSeeder::class);
        if (app()->environment() != 'dev' || app()->environment() != 'local') {
            $this->call(MessagesSeeder::class);
            $this->call(NotificationsSeeder::class);
            $this->call(PagesSeeder::class);
            $this->call(SlidesSeeder::class);
            $this->call(PostsSeeder::class);
            $this->call(ProductsSeeder::class);
            $this->call(OrdersSeeder::class);
            $this->call(CartSeeder::class);
            $this->call(ReviewsSeeder::class);
            $this->call(FavouritesSeeder::class);
            $this->call(VouchersSeeder::class);

        }
    }

}
