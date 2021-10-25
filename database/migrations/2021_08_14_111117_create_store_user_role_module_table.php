<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreUserRoleModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user_role_module', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('role_id');
            $table->integer('module_id');
            $table->integer('c')->nullable()->default(0);
            $table->integer('r')->nullable()->default(0);
            $table->integer('u')->nullable()->default(0);
            $table->integer('d')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_user_role_module');
    }
}
