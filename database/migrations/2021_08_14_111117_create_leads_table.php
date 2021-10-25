<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('whats_app')->nullable();
            $table->integer('phone_country_code_id')->nullable();
            $table->integer('whats_app_country_code_id')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('lead_status_id')->nullable();
            $table->integer('lead_type_id')->nullable();
            $table->unsignedBigInteger('store_user_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->unsignedBigInteger('lead_source_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->integer('town_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pincode')->nullable();
            $table->string('email_token', 250)->nullable();
            $table->string('sms_token')->nullable();
            $table->tinyInteger('converted_to_store')->default(0);
            $table->tinyInteger('email_verify')->default(0);
            $table->tinyInteger('phone_verify')->default(0);
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
        Schema::dropIfExists('leads');
    }
}
