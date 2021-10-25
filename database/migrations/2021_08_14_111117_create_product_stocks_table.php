<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('itemid')->nullable();
            $table->string('gin')->nullable();
            $table->string('iname')->nullable();
            $table->string('invoice_detail_grade_id', 20)->nullable();
            $table->string('invoice_detail_grade_packet_id', 20)->nullable()->default('0');
            $table->string('number')->nullable();
            $table->string('alias')->nullable();
            $table->string('ratti_id', 20)->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('depth')->nullable();
            $table->string('weight')->nullable()->default('0');
            $table->string('primary_image', 500)->nullable();
            $table->string('primary_video', 500)->nullable();
            $table->string('product_id', 21)->nullable();
            $table->integer('product_category_id')->nullable()->default(2);
            $table->string('field7')->nullable();
            $table->string('color_id', 21)->nullable();
            $table->string('field9')->nullable();
            $table->string('clarity_id', 21)->nullable();
            $table->string('field19')->nullable();
            $table->string('grade_id', 20)->nullable();
            $table->string('rate_profile_id', 25)->nullable()->default('0');
            $table->string('field13')->nullable();
            $table->string('origin_id', 20)->nullable();
            $table->string('field8')->nullable();
            $table->string('shape_id', 21)->nullable();
            $table->string('field14')->nullable();
            $table->string('specie_id', 21)->nullable();
            $table->string('sg', 20)->nullable();
            $table->string('ri', 21)->nullable();
            $table->string('field10')->nullable();
            $table->string('treatment_id', 21)->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->tinyInteger('final')->nullable()->default(0);
            $table->tinyInteger('verified')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('in_stock')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stocks');
    }
}
