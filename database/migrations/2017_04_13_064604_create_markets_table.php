<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('ad_img_id')->nullable();
            $table->enum('category', [
                'road', 'mtb', 'fixed', 'hybrid', 'mini',
                'bacc', 'racc', 'part'
            ]);
            $table->boolean('is_certied')->default(false);
            $table->tinyInteger('view_count')->default(0);
            $table->string('ad_title');
            $table->enum('ad_status', ['판매', '인증', '완료']);
            $table->enum('product_status', ['S', 'A', 'B', 'C', 'D']);
            $table->unsignedInteger('price');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->boolean('is_direct')->default(true);;
            $table->string('direct_info')->nullable();
            $table->boolean('is_ship')->default(false);;
            $table->string('ship_info')->default('포함')->nullable();
            $table->boolean('is_trade')->default(false);;
            $table->string('trade_info')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->timestamp('selled_at')->nullable();
            $table->softDeletes();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');


        });

        if (config('database.default') == 'mysql') {
            DB::statement('ALTER TABLE markets ADD FULLTEXT search(ad_title, brand, model, description)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropForeign('markets_seller_id_foreign');
        });
        Schema::dropIfExists('markets');
    }
}
