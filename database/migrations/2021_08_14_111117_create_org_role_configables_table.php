<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgRoleConfigablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_role_configables', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('org_id')->nullable();
            $table->integer('org_role_id');
            $table->integer('org_role_configable_id');
            $table->string('org_role_configable_type');
            $table->integer('created_by')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('org_role_configables');
    }
}
