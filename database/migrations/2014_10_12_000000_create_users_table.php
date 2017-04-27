<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password', 60)->nullable();
            $table->string('confirm_code', 60)->nullable();
            $table->boolean('activated')->default(0);
            $table->string('facebook_id')->nullable()->unique();
            $table->string('naver_id')->nullable()->unique();
            $table->string('google_id')->nullable()->unique();
            $table->string('kakao_id')->nullable()->unique();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
