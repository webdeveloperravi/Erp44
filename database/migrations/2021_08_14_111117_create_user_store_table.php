<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_store', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('guard_id')->nullable()->default(5);
            $table->bigInteger('store_role_id')->nullable()->default(0);
            $table->integer('manager_role_id')->nullable();
            $table->string('account_group_id')->nullable();
            $table->integer('org_id')->nullable()->default(0);
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('otp_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('whats_app')->nullable();
            $table->integer('phone_country_code_id')->nullable();
            $table->integer('whats_app_country_code_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('type', 50)->nullable();
            $table->string('sub_domain')->nullable();
            $table->integer('security_pin')->nullable();
            $table->integer('email_verify')->nullable();
            $table->integer('phone_verify')->nullable();
            $table->integer('sale_order_temp_number')->nullable();
            $table->string('voucher_number')->nullable();
            $table->string('email_token')->nullable();
            $table->string('sms_token')->nullable();
            $table->integer('sale_invoice_temp_number')->nullable();
            $table->integer('sale_chalan_temp_number')->nullable();
            $table->integer('invoice_number')->nullable();
            $table->string('so_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('ch_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_store');
    }
}
