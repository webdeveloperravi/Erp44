<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagerPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_packets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('packet_id')->nullable();
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('super_id');
            $table->timestamp('date')->useCurrent();
            $table->string('status')->nullable()->default('0');
            $table->timestamps();
            $table->tinyInteger('finsh')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manager_packets');
    }
}
