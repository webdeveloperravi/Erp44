<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('guard_id')->nullable();
            $table->string('title');
            $table->string('description', 2000)->nullable();
            $table->string('route')->nullable();
            $table->integer('parent')->nullable();
            $table->integer('parent_sort')->nullable();
            $table->integer('child_sort')->nullable();
            $table->unsignedInteger('created_by');
            $table->tinyInteger('status')->nullable()->default(1);
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
        Schema::dropIfExists('modules');
    }
}
