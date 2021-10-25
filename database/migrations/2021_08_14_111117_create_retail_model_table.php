<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_model', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('alias');
            $table->string('description', 500);
            $table->bigInteger('retail_type_id');
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->bigInteger('discount_id');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('retail_model');
    }
}
