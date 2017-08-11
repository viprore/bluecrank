<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
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
        $products = App\Product::all();

        $articles->each(function ($article) {
            $range = rand(0,3);
            while ($range-- > 0) {
                $article->comments()->save(factory(App\Comment::class)->make());
            }
//            $commentable_type = App\Article::class;
//            $deleted_at = Carbon\Carbon::now()->toDateTimeString();
//            $article->comments()->save(factory(App\Comment::class)->make(
//                compact('commentable_type', 'deleted_at')
//            ));
        });


        $products->each(function ($product) {
            $range = rand(0,3);
            while ($range-- > 0) {
                $product->comments()->save(factory(App\Comment::class)->make());
            }
        });

        // 댓글의 댓글(자식 댓글)
        $articles->each(function ($article) use ($faker){
            $commentIds = App\Comment::where('commentable_type', App\Article::class)
                ->where('commentable_id', $article->id)
                ->where('parent_id', null)
                ->pluck('id')->toArray();

            if ($commentIds != null) {
                $now = Carbon\Carbon::now()->toDateTimeString();
                foreach(range(1, rand(1,3)) as $index) {
                    $article->comments()->save(
                        factory(App\Comment::class)->make([
                            'parent_id' => $faker->randomElement($commentIds),
                            'deleted_at' => $faker->optional()->randomElement([null, $now]),
                        ])
                    );
                }
            }
        });

        $products->each(function ($product) use ($faker){
            $commentIds = App\Comment::where('commentable_type', App\Product::class)
                ->where('commentable_id', $product->id)
                ->where('parent_id', null)
                ->pluck('id')->toArray();

            if ($commentIds != null) {
                $now = Carbon\Carbon::now()->toDateTimeString();
                foreach (range(1, rand(1, 3)) as $index) {
                    $product->comments()->save(
                        factory(App\Comment::class)->make([
                            'parent_id' => $faker->randomElement($commentIds),
                            'deleted_at' => $faker->optional()->randomElement([null, $now]),
                        ])
                    );
                }
            }
        });


        $this->command->info('Seeded: comments table');
    }
}
