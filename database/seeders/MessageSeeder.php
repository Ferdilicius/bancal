<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\MessageType;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $messageTypes = MessageType::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                Message::create([
                    'user_id' => $user->id,
                    'message_type_id' => $messageTypes->random()->id,
                    'content' => fake()->sentence(),
                ]);
            }
        }

        // Crear 5 mensajes sin usuario
        for ($i = 0; $i < 5; $i++) {
            Message::create([
                'user_id' => null,
                'email' => fake()->email(),
                'message_type_id' => $messageTypes->random()->id,
                'content' => "Mensaje sin usuario {$i}",
            ]);
        }
    }
}
