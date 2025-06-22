<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MessageType;
use App\Models\User;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'content' => $this->faker->paragraph(),
            'user_id' => User::inRandomOrder()->first()->id,
            'message_type_id' => MessageType::inRandomOrder()->first()->id, 
        ];
    }
}
