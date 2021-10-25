<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetailTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retail_types', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('alias');
            $table->string('description', 500);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_ta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retail_types');
    }
}
