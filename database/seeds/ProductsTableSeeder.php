<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 10)->create();

        $this->command->info('Seeded: products table');

        $faker = app(Faker\Generator::class);
        $products = App\Product::all();

        /* 옵션 & reviews */
        $products->each(function ($product) use ($faker) {
            $range = rand(1,3);
            while ($range > 0) {
                $product->options()->save(factory(App\Option::class)->make());
                $range--;
            }

            $range = rand(0, 3);
            while ($range > 0) {
                $product->reviews()->save(factory(App\Review::class)->make());
                $range--;
            }
        });


        $this->command->info('Seeded: options, reviews table');
    }
}
