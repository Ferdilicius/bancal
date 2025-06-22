<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayMethodFactory extends Factory
{

	public function definition()
	{
		return [
			'name' => $this->faker->word,
			'type' => $this->faker->randomElement(['card', 'paypal', 'bizum', 'other']),
			'status' => $this->faker->randomElement(['active', 'inactive']),
			'user_id' => User::inRandomOrder()->first()->id,
		];
	}
}
