<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_admin', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('guard_id')->default(1);
            $table->tinyInteger('logged')->nullable()->default(0);
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whats_app')->nullable();
            $table->integer('whats_app_country_code_id')->nullable();
            $table->integer('phone_country_code_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('security_pin')->nullable();
            $table->tinyInteger('email_verify')->default(0);
            $table->tinyInteger('mobile_verify')->default(0);
            $table->string('otp_code')->nullable();
            $table->integer('org_id')->nullable()->default(1);
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
        Schema::dropIfExists('user_admin');
    }
}
