<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('products')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE products AUTO_INCREMENT = 1");
        }
        $categories=\App\Models\Category::whereNotNull('top_id')->get();
        if($categories){
            foreach ($categories as $category){
                factory(App\Models\Product::class, 10)->create([
                    'category_id'=>$category->id
                ]);
            }
        }
    }
}
