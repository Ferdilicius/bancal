<?php

namespace Database\Factories;

use App\Models\PayMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayMethodFactory extends Factory
{
    protected $model = PayMethod::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Tarjeta', 'PayPal', 'Transferencia']),
            'description' => $this->faker->sentence(),
        ];
    }
}