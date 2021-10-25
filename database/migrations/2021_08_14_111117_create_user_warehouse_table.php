<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_warehouse', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('guard_id');
            $table->bigInteger('role_id');
            $table->tinyInteger('logged')->nullable()->default(0);
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whats_app');
            $table->integer('whats_app_country_code_id')->nullable();
            $table->integer('phone_country_code_id')->nullable();
            $table->string('security_pin')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('email_verify')->default(0);
            $table->tinyInteger('phone_verify')->default(0);
            $table->string('otp_code')->nullable();
            $table->string('user_pic')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('user_warehouse');
    }
}
