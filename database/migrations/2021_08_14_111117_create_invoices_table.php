<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_number');
            $table->string('total_amount')->nullable();
            $table->integer('vendor_id')->default(1);
            $table->integer('dept_id_receive');
            $table->integer('user_id_receive');
            $table->timestamp('date')->useCurrent();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('complete')->nullable()->default(0);
            $table->tinyInteger('authorization')->default(0);
            $table->integer('authorized_by')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
