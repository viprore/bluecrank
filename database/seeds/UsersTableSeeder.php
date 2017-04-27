<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => '블루크랭크',
            'email' => 'info@bluecrank.net',
            'password' => bcrypt('wjdfud09'),
            'phone' => '010-6888-7457',
            'activated' => 1
        ]);

        factory(App\User::class)->create([
            'name' => '이동민',
            'email' => 'lsarading@bluecrank.net',
            'password' => bcrypt('qhdks1013'),
            'phone' => '010-2987-5885',
            'activated' => 1
        ]);

        factory(App\User::class, 5)->create();

        $this->command->info('Seeded: users table');
    }
}
