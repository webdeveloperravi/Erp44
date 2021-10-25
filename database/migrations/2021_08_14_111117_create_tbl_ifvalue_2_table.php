<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblIfvalue2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ifvalue_2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('depth')->nullable();
            $table->string('weight')->nullable();
            $table->string('ri')->nullable();
            $table->string('sg')->nullable();
            $table->string('color')->nullable();
            $table->string('shape')->nullable();
            $table->string('clarity')->nullable();
            $table->string('treatment')->nullable();
            $table->string('picture')->nullable();
            $table->string('origin')->nullable();
            $table->string('specie')->nullable();
            $table->string('grade')->nullable();
            $table->string('label_id')->nullable();
            $table->string('seal_1')->nullable();
            $table->string('seal_2')->nullable();
            $table->integer('ratti_id')->nullable();
            $table->integer('rate_profile_id')->nullable();
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
        Schema::dropIfExists('tbl_ifvalue_2');
    }
}
