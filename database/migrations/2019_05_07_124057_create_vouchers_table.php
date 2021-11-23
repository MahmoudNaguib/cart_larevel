<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVouchersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable()->index();
            $table->bigInteger('currency_id')->nullable()->index();
            $table->float('amount', 11, 2)->nullable()->index()->default(0);
            $table->date('expiry_date')->nullable()->index();
            $table->integer('max_usage')->nullable()->index()->default(1);
            $table->integer('used')->nullable()->index()->default(0);
            $table->bigInteger('created_by')->nullable()->index()->default(NULL);
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('vouchers');
    }

}
