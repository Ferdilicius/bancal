<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // User::all()->each(function ($user) {
        //     Payment::factory()->count(2)->create([
        //         'user_id' => $user->id,
        //     ]);
        // });
    }
}