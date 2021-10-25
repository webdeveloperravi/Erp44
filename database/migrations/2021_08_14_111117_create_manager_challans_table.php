<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagerChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_challans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_detail_grade_id');
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('super_id');
            $table->string('challan_number');
            $table->timestamp('date')->useCurrent();
            $table->string('status');
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
        Schema::dropIfExists('manager_challans');
    }
}
