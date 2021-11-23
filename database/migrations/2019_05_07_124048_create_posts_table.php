<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('section_id')->nullable()->index();
            $table->mediumtext('title')->nullable();
            $table->mediumtext('slug')->nullable();
            $table->mediumtext('summary')->nullable();
            $table->text('content')->nullable(); // required
            $table->string('tags')->nullable()->index();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->nullable()->default(1)->index();
            $table->bigInteger('views')->nullable()->index()->default(0);
            $table->bigInteger('created_by')->nullable()->index();
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable()->index();
        });
        if (app()->environment() != 'testing') {
            Schema::table('posts', function (Blueprint $table) {
                \DB::statement('ALTER TABLE posts ADD FULLTEXT search(`title`,`content`)');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('posts');
    }

}
