<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailGradePacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_detail_grade_packets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_detail_grade_id');
            $table->string('number');
            $table->string('total_piece');
            $table->bigInteger('ratti_id')->nullable();
            $table->tinyInteger('return_to_super')->nullable()->default(0);
            $table->integer('authorization')->nullable()->default(0);
            $table->integer('authorized_by')->nullable();
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
        Schema::dropIfExists('invoice_detail_grade_packets');
    }
}
