<?php

use Illuminate\Database\Seeder;

class MarkkablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $users = App\User::all();
        $articles = App\Article::all();
        $products = App\Product::all();

        foreach($users as $user) {
            $user->wantProducts()->sync(
                $faker->randomElements(
                    $products->pluck('id')->toArray(),
                    rand(1, 5)
                )
            );

            $user->wantArticles()->sync(
                $faker->randomElements(
                    $articles->pluck('id')->toArray(),
                    rand(1, 5)
                )
            );
        }

        $this->command->info('Seeded: markkables table');
    }
}
