<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('posts')->delete();
        if (app()->environment() != 'testing') {
            DB::statement("ALTER TABLE posts AUTO_INCREMENT = 1");
        }
        $sections=\App\Models\Section::get();
        if($sections){
            foreach ($sections as $section){
                factory(App\Models\Post::class, 3)->create(['section_id'=>$section->id]);
            }
        }

    }

}
