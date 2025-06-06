<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => Hash::make('1'),
        ]);

        User::factory(15)->create();
    }
}
