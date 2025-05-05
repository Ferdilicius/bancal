<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create();

		Product::factory()->count(12)->create();

		Product::factory()->create([
			'name' => $faker->word,
			'description' => $faker->sentence,
			'quantity' => $faker->numberBetween(0, 100),
			'price' => $faker->randomFloat(2, 10, 1000),
			'user_id' => 1,
		]);
	}
}
