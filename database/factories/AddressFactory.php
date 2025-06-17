<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\AddressType;

class AddressFactory extends Factory
{
    protected $addressesNames = [
        'Casa',
        'Casa Campo',
        'Casa Playa',
        'Finquica',
        'Barraquica',
        'El Monasterio',
        'Villa Paloma'
    ];
    
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'name' => $this->faker->randomElement($this->addressesNames),
            'status' => $this->faker->randomElement(['inactivo', 'activo']),
            'user_id' => User::factory(),
            'address_type_id' => AddressType::factory(),
        ];
    }
}


// public function fakeFullAddress()
//     {
//         $streetTypes = [
//             'Avenida',
//             'Carril',
//             'Calle',
//             'Camino',
//             'Travesía',
//             'Paseo',
//             'Plaza'
//         ];

//         $streetType = $this->faker->randomElement($streetTypes);
//         $streetName = $this->faker->randomElement($this->addressesNames);
//         $portalNumber = $this->faker->buildingNumber;
//         $postalCode = $this->faker->postcode;
//         $escalera = $this->faker->optional()->randomElement(['A', 'B', 'C', 'D']);

//         // Todo en un solo string
//         $address = "{$streetType} {$streetName}, {$portalNumber}";
//         if ($escalera) {
//             $address .= ", Escalera {$escalera}";
//         }
//         $address .= ", {$postalCode}";

//         return $address;
//     }