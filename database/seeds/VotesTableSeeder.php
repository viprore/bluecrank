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

        $comments->each(function ($comment) {
            foreach(range(1,5) as $index) {
                $comment->votes()->save(factory(App\Vote::class)->make());
            }
        });

        $this->command->info('Seeded: votes table');
    }
}
