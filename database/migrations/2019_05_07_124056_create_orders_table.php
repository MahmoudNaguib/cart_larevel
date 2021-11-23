<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('full_address');
            $table->string('contact_name');
            $table->string('contact_mobile');
            $table->text('products'); // json data
            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'In-Progress', 'In-Shipment', 'Delivered', 'Returned'])->index()->default('Pending'); //'Pending','Confirmed','Cancelled','In-Progress','In-Shipment','Delivered','Returned
            $table->float('sub_total', 11, 2)->nullable()->default(0)->index();
            $table->bigInteger('currency_id')->nullable()->index();
            $table->float('sub_total_local', 11, 2)->nullable()->default(0)->index();
            $table->bigInteger('voucher_id')->nullable()->index();
            $table->float('voucher_amount', 11, 2)->index()->default(0);
            $table->float('total', 11, 2)->nullable()->default(0)->index();
            $table->float('total_local', 11, 2)->nullable()->default(0)->index();
            $table->bigInteger('created_by')->nullable()->index();
            $table->bigInteger('address_id')->nullable()->index();
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
        Schema::dropIfExists('orders');
    }

}
