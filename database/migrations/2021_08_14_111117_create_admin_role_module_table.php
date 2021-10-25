<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRoleModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role_module', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('role_id');
            $table->integer('module_id');
            $table->tinyInteger('create')->nullable();
            $table->tinyInteger('read')->nullable();
            $table->tinyInteger('update')->nullable();
            $table->tinyInteger('delete')->nullable();
            $table->tinyInteger('ca')->nullable()->default(0);
            $table->tinyInteger('ra')->nullable()->default(0);
            $table->tinyInteger('ua')->nullable()->default(0);
            $table->tinyInteger('da')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role_module');
    }
}
