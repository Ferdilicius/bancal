<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;

class OrderProductFactory extends Factory
{
	public function definition()
	{
		return [
			'order_id' => Order::inRandomOrder()->first()->id,
			'product_id' => Product::inRandomOrder()->first()->id,
		];
	}
}
