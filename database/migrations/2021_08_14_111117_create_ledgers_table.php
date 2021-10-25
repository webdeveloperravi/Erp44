<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('guard_id_from')->nullable();
            $table->integer('guard_id_to')->nullable();
            $table->string('voucher_type')->nullable();
            $table->integer('voucher_number')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('amount_total');
            $table->integer('qty_total');
            $table->integer('addOnsAmount');
            $table->integer('subTotal');
            $table->integer('shippingCharges');
            $table->integer('taxAmount');
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
            $table->integer('discount_id')->nullable();
            $table->float('discount_amount', 10)->nullable();
            $table->float('products_amount', 10)->nullable();
            $table->float('tax_amount', 10)->nullable();
            $table->float('total_amount', 10)->nullable();
            $table->integer('qty_total')->nullable();
            $table->string('comment')->nullable();
            $table->string('comment_to')->nullable();
            $table->timestamps();
            $table->float('mrp_without_tax', 10)->nullable();
            $table->float('amount_with_discount', 10)->nullable();
            $table->float('ratti_rate_without_tax', 10)->nullable();
            $table->integer('from_payment_account')->nullable();
            $table->integer('to_payment_account')->nullable();
            $table->integer('reference_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
