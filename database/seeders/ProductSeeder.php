<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
	public function run()
	{
		$users = User::all();

		foreach ($users as $user) {
			Product::factory()->count(3)->create([
				'user_id' => $user->id,
			]);
		}
	}
}
