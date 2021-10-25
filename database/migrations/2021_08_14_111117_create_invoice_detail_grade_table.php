<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_detail_grade', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_detail_id');
            $table->integer('grade_id');
            $table->integer('user_id')->nullable();
            $table->string('carat');
            $table->integer('piece');
            $table->timestamps();
            $table->tinyInteger('generate_id')->nullable()->default(0);
            $table->tinyInteger('issue_to_manager')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_detail_grade');
    }
}
