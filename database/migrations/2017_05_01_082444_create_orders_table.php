<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('postcode');
            $table->string('find_address');
            $table->string('input_address');
            $table->string('contact');
            $table->string('please')->nullable();
            $table->enum('paymethod', ['계좌이체', '무통장입금', '신용카드'])->default('계좌이체');
            $table->unsignedInteger('amount');
            $table->string('ship_code')->nullable();
            $table->enum('status', [
                '작성중', '입금전', '입금완료', '배송준비', '배송중', '배송완료', '구매결정', '반품', '취소'])
                ->default('작성중');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_order_id_foreign');
        });

        Schema::dropIfExists('orders');
    }
}
