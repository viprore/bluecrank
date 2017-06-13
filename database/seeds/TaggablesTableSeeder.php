<?php

use Illuminate\Database\Seeder;

class TaggablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $articles = App\Article::all();
        $olds = App\Product::where('is_old', true)->get();
        $products = App\Product::where('is_old', false)->get();
        $tags = App\Tag::all();

        foreach ($articles as $article) {
            $article->tags()->sync(
                $faker->randomElements(
                    $tags->where('type', 'articles')
                        ->pluck('id')
                        ->toArray(),
                    rand(1,3)
                )
            );
        }

        foreach ($olds as $old) {
            $old->tags()->sync(
                $faker->randomElements(
                    $tags->where('type', 'olds')
                        ->pluck('id')
                        ->toArray(),
                    rand(1,3)
                )
            );
        }

        foreach ($products as $product) {
            $product->tags()->sync(
                $faker->randomElements(
                    $tags->where('type', 'products')
                        ->pluck('id')
                        ->toArray(),
                    rand(1,3)
                )
            );
        }

        $this->command->info('Seeded: taggables table');
    }
}
