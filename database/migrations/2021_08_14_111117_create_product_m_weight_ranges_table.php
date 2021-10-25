<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMWeightRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_m_weight_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('from');
            $table->integer('to');
            $table->string('rati_standard');
            $table->string('rati_big');
            $table->string('carat');
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_m_weight_ranges');
    }
}
