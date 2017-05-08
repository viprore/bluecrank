<?php

use Illuminate\Database\Seeder;

class CertificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();


        foreach ($users as $user) {
            $certi = factory(App\Certification::class)->make();
//            $certifications = App\Certification::all();

            $user->certifications()->save($certi);
        }
    }
}
