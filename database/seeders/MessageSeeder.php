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
    }
}
