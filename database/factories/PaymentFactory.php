<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'method' => $this->faker->randomElement(['stripe', 'paypal', 'bizum', 'transferencia']),
            'payment_intent_id' => $this->faker->optional()->uuid,
            'status' => $this->faker->randomElement(['pendiente', 'completado', 'fallido']),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}