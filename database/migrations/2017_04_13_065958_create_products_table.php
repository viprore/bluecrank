<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ad_img_id')->nullable();

            $table->enum('category', [
                'road', 'mtb', 'fixed', 'hybrid', 'mini',
                'bacc', 'racc', 'part'
            ]);
            $table->tinyInteger('view_count')->default(0);
            $table->string('ad_title');
            $table->enum('ad_status', ['준비중', '판매', '매진']);
            $table->string('ad_short_description')->nullable();
            $table->unsignedInteger('price');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        if (config('database.default') == 'mysql') {
            DB::statement('ALTER TABLE products ADD FULLTEXT search(ad_title, ad_short_description)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
