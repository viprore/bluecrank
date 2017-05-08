<?php

use Illuminate\Database\Seeder;

class BuyProcessRelatedTableSeeder extends Seeder
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
            foreach (range(1, rand(1, 3)) as $index) {
                $user->ships()->save(
                    factory(App\Ship::class)->make()
                );
            }

            foreach (range(1, rand(1, 3)) as $index) {
                $user->orders()->save(
                    factory(App\Order::class)->make()
                );
            }
        }

        $orders = App\Order::all();

        foreach ($orders as $order) {
            foreach (range(1, rand(1, 5)) as $index) {
                $order->items()->save(
                    factory(App\Item::class)->make()
                );
            }
        }

    }
}
