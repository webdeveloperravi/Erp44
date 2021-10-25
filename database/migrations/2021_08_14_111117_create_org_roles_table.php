<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_roles', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('description', 500);
            $table->integer('retail_model_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('tax_type_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
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
        Schema::dropIfExists('org_roles');
    }
}
