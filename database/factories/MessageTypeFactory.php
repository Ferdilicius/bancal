<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageTypeFactory extends Factory
{
    protected $messageTypesNames = [
        'Configuración del perfil',
        'Creación o modificación de producto',
        'Creación o modificación de una dirección (bancal)',
        'Proceso de compraventa'];
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement($this->messageTypesNames)
        ];
    }
}
