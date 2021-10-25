<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('ledger_id')->nullable();
            $table->integer('product_stock_id')->nullable();
            $table->string('gin')->nullable();
            $table->string('product_unit_qty')->nullable();
            $table->string('product_unit_rate')->nullable();
            $table->float('product_amount', 10)->nullable();
            $table->string('temp_number', 11)->nullable();
            $table->integer('new_ledger_id')->nullable();
            $table->integer('ledger_status')->nullable()->default(0);
            $table->integer('discount_id')->nullable();
            $table->float('discount_amount', 10)->nullable();
            $table->float('discount_rate', 10)->nullable();
            $table->integer('tax_type_id')->nullable();
            $table->float('tax_rate', 10)->nullable();
            $table->float('tax_amount', 10)->nullable();
            $table->float('total_amount', 10)->nullable();
            $table->string('product_unit_qty_two', 11)->nullable();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->float('weight', 10)->nullable();
            $table->float('mrp_without_tax', 10)->nullable();
            $table->float('ratti_rate_without_tax', 10)->nullable();
            $table->float('amount_with_discount', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledger_details');
    }
}
