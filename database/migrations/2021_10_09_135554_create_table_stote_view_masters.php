<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStoteViewMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_view_masters', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('phone_country_code_id')->nullable();
            $table->foreignId('store_id')->nullable();
            $table->string('address')->nullable(); 
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
        Schema::dropIfExists('store_view_master');
    }
}
