<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlurbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blurbs', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('target');
            $table->string('link')->nullable();
            $table->boolean('is_blank')->default(false);
            $table->string('title');
            $table->string('text1')->nullable();
            $table->string('text2')->nullable();
            $table->tinyInteger('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blurbs');
    }
}
