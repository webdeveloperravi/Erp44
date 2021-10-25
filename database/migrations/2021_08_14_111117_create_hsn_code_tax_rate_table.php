<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHsnCodeTaxRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hsn_code_tax_rate', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('hsn_code_id');
            $table->bigInteger('tax_rate_id');
            $table->string('created_date');
            $table->integer('status')->default(0);
            $table->integer('created_by');
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
        Schema::dropIfExists('hsn_code_tax_rate');
    }
}
