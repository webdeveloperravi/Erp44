<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('so_number')->nullable();
            $table->string('po_number')->nullable();
            $table->unsignedBigInteger('seller_store_id');
            $table->unsignedBigInteger('buyer_store_id');
            $table->integer('ledger_id')->nullable();
            $table->string('slug');
            $table->integer('tax');
            $table->enum('Tax_type', ['gst', 'vat']);
            $table->tinyInteger('discount');
            $table->enum('discount_type', ['per', 'val']);
            $table->integer('discount_amount');
            $table->string('ordernote');
            $table->foreignId('shipping_address');
            $table->string('shipping_charges');
            $table->enum('payment_status', ['pending', 'paid']);
            $table->string('status');
            $table->string('cancelling_reason');
            $table->string('track_id');
            $table->tinyInteger('status');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_purchase_orders');
    }
}
