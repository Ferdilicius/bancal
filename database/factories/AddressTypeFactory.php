<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressTypeFactory extends Factory
{
    protected $addressTypesNames = [
        'Bancal',
        'Huero urbano privado',
        'Huerto urbano público',
        'Huerto escolar'
    ];
    public function definition(): array
    {
        return [
			'name' => $this->faker->unique()->randomElement($this->addressTypesNames)
		];
    }
}
