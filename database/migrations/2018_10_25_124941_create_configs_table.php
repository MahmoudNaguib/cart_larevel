<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('configs',
                function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('field_type')->nullable()->default('text'); // text, textarea, file
            $table->string('field_class')->nullable(); 
            $table->string('type')->nullable()->index();
            $table->string('field')->nullable();
            $table->string('label')->nullable();
            $table->mediumtext('value')->nullable();
            $table->string('lang')->nullable()->index();
            $table->bigInteger('created_by')->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('configs');
    }

}
