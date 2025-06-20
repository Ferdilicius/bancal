<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageType;

class MessageTypeSeeder extends Seeder
{
    public function run(): void
    {
        MessageType::create(['name' => 'Consulta']);
        MessageType::create(['name' => 'Configuración del perfil']);
        MessageType::create(['name' => 'Creación o modificación de producto']);
        MessageType::create(['name' => 'Creación o modificación de una dirección (bancal)']);
        MessageType::create(['name' => 'Proceso de compraventa']);
    }
}
