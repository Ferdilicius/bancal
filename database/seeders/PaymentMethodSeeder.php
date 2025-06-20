<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate de tener usuarios en la base de datos
        if (User::count() === 0) {
            \App\Models\User::factory()->count(5)->create();
        }

        // Agrega 1-3 métodos de pago por usuario
        User::all()->each(function ($user) {
            PaymentMethod::factory()
                ->count(rand(1, 3))
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
