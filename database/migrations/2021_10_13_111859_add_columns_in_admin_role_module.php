<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInAdminRoleModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_role_module', function (Blueprint $table) {
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
        Schema::table('admin_role_module', function (Blueprint $table) {
            //
        });
    }
}
