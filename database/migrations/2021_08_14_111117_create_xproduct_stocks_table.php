<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXproductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xproduct_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->bigInteger('itemid')->nullable();
            $table->bigInteger('gin')->nullable();
            $table->string('iname')->nullable();
            $table->string('invoice_detail_grade_id', 20)->nullable();
            $table->string('invoice_detail_grade_packet_id', 20)->nullable()->default('0');
            $table->string('product_id', 21)->nullable();
            $table->integer('product_category_id')->nullable()->default(2);
            $table->string('ratti_id', 20)->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('depth')->nullable();
            $table->string('weight')->nullable()->default('0');
            $table->string('color_id', 21)->nullable();
            $table->string('clarity_id', 21)->nullable();
            $table->string('grade_id', 20)->nullable();
            $table->string('origin_id', 20)->nullable();
            $table->string('shape_id', 21)->nullable();
            $table->string('specie_id', 21)->nullable();
            $table->string('sg', 20)->nullable();
            $table->string('ri', 21)->nullable();
            $table->string('primary_image', 500)->nullable();
            $table->string('primary_video', 500)->nullable();
            $table->string('treatment_id', 21)->nullable();
            $table->string('rate_profile_id', 25)->nullable()->default('0');
            $table->tinyInteger('status')->nullable()->default(1);
            $table->tinyInteger('final')->nullable()->default(0);
            $table->tinyInteger('in_stock')->default(1);
            $table->tinyInteger('verified')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('xproduct_stocks');
    }
}
