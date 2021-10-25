<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacketProcessingChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet_processing_challans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('packet_id');
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('super_id');
            $table->string('challan_number');
            $table->timestamp('date')->nullable();
            $table->string('status');
            $table->integer('authorization')->nullable()->default(0);
            $table->integer('authorized_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('packet_processing_challans');
    }
}
