<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRateProfileWeightRangeUnitRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_rate_profile_weight_range_unit_rate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rate_profile_weight_range_id');
            $table->integer('rate_profile_id');
            $table->string('ratti_rate')->default('0');
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
        Schema::dropIfExists('product_rate_profile_weight_range_unit_rate');
    }
}
