<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseRoleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_role_actions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('role_id');
            $table->integer('action_id')->nullable();
            $table->tinyInteger('allow')->nullable()->default(0);
            $table->tinyInteger('authorization')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_role_actions');
    }
}
