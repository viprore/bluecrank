<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('amount');
            $table->string('apply_num');
            $table->string('buyer_addr');
            $table->string('buyer_email');
            $table->string('buyer_name');
            $table->string('buyer_tel');
            $table->string('imp_uid');
            $table->string('merchant_uid');
            $table->string('name');
            $table->timestamp('paid_at');
            $table->string('pay_method');
            $table->string('receipt_url');
            $table->string('status');
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
        Schema::dropIfExists('payments');
    }
}
