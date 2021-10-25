<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_product_detail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id');
            $table->integer('vendor_id');
            $table->integer('product_id');
            $table->integer('product_cate_id');
            $table->bigInteger('unit_id')->nullable();
            $table->string('carat');
            $table->string('piece');
            $table->string('rate');
            $table->string('amount')->default('1');
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('complete')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_product_detail');
    }
}
