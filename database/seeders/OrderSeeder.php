<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Arr;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $halfUsers = $users->random(floor($users->count() / 2));

        foreach ($halfUsers as $user) {
            for ($i = 0; $i < 2; $i++) {
                Order::create([
                    'user_id' => $user->id,
                    'total' => rand(1000, 10000) / 100,
                    'status' => Arr::random(['pendiente', 'pagado', 'cancelado']),
                ]);
            }
        }
    }
}
