<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('mobile')->nullable()->index();
            $table->string('password')->nullable();
            $table->string('image', 190)->nullable();
            $table->bigInteger('country_id')->nullable()->index();
            $table->bigInteger('currency_id')->nullable()->default(env('DEFAULT_CURRENCY',1))->index();
            $table->string('language', 2)->nullable()->default('en')->index();
            $table->string('remember_token', 190)->nullable();
            $table->string('confirm_token', 190)->nullable();
            $table->string('last_ip', 190)->nullable();
            $table->timestamp('last_logged_in_at')->nullable();
            $table->boolean('confirmed')->nullable()->default(0)->index();
            $table->boolean('is_active')->nullable()->default(1)->index();
            $table->string('token')->nullable()->index();
            $table->bigInteger('created_by')->nullable()->index();
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable()->index();
        });
        if (app()->environment() != 'testing') {
            Schema::table('users', function (Blueprint $table) {
                \DB::statement('ALTER TABLE users ADD FULLTEXT search(`name`,`email`,`mobile`)');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
