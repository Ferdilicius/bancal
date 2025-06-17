<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['pendiente', 'pagado', 'cancelado']),
        ];
    }
}