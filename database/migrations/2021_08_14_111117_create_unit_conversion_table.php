<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitConversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_conversion', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('unit_main_id');
            $table->bigInteger('unit_sub_id');
            $table->string('conversion');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
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
        Schema::dropIfExists('unit_conversion');
    }
}
