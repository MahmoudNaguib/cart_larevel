<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->nullable()->index();
            $table->mediumtext('title')->nullable();
            $table->mediumtext('slug')->nullable();
            $table->mediumtext('summary')->nullable();
            $table->text('content')->nullable(); // required
            $table->bigInteger('currency_id')->nullable()->index();
            $table->float('price', 11, 2)->nullable()->default(0)->index();
            $table->float('discount', 11, 2)->nullable()->default(0)->index();
            $table->float('final_price', 11, 2)->nullable()->default(0)->index();
            $table->float('final_price_local', 11, 2)->nullable()->default(0)->index();
            $table->string('tags')->nullable()->index();
            $table->string('image')->nullable();
            $table->boolean('is_active')->nullable()->default(1)->index();
            $table->bigInteger('views')->nullable()->index()->default(0);
            $table->bigInteger('created_by')->nullable()->index();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable()->index();
        });
        if (app()->environment() != 'testing') {
            Schema::table('products', function (Blueprint $table) {
                \DB::statement('ALTER TABLE products ADD FULLTEXT search(`title`,`content`)');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}
