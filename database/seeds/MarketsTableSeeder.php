<?php

use Illuminate\Database\Seeder;

class MarketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Market::class, 10)->create();

        $this->command->info('Seeded: markets table');
    }
}
