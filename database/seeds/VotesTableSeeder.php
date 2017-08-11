<?php

use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = App\Comment::all();
        $faker = Faker\Factory::create('ko_KR');


        $comments->each(function ($comment) use ($faker) {
            foreach(range(1,5) as $index) {
                $comment->votes()->save(factory(App\Vote::class)->make([
                    'voted_at' => $faker->dateTimeBetween($comment->created_at)
                ]));
            }
        });

        $this->command->info('Seeded: votes table');
    }
}
