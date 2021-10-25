<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInStorePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_purchase_orders', function (Blueprint $table) {
            $table->boolean('approved')->default(0)->after('ledger_id');
            $table->foreignId('approved_by')->nullable()->after('approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->dropColumn('approved_by');
        });
    }
}
