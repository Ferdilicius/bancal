<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayMethod;
use App\Models\User;

class PayMethodSeeder extends Seeder
{
    public function run()
    {
        // Crea 4 métodos de pago
        $payMethods = PayMethod::factory()->count(4)->create();

        // Asigna uno aleatorio a cada usuario
        User::all()->each(function ($user) use ($payMethods) {
            $user->payment_id = $payMethods->random()->id;
            $user->save();
        });
    }
}
