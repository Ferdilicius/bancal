<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;
use App\Models\AddressType;

class AddressSeeder extends Seeder
{
    public function run()
	{
		$users = User::all();
        $addressTypes = AddressType::all();	

		foreach ($users as $user) {
			Address::factory()->count(2)->create([
				'user_id' => $user->id,
                'address_type_id' => $addressTypes->random()->id,
			]);
		}
	}
}
