<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSecurityPinRegenerateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_pin_regenerate_requests', function (Blueprint $table) {
            $table->id();
            $table->string('requestable_type');
            $table->bigInteger('requestable_id');
            $table->text('message')->nullable();
            $table->text('resolved_by')->nullable(); 
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
        Schema::dropIfExists('security_pin_regenerate_requests');
    }
}
