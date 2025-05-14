<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(ProductCategorySeeder::class);

        $this->call(ProductSeeder::class);

<<<<<<< HEAD
<<<<<<< HEAD
        $this->call(AddressTypeSeeder::class);

        $this->call(AddressSeeder::class);
=======
>>>>>>> 6684643ade7598efa8bbdbf04b4ec01d8a30c251
=======
        // $this->call(AddressTypeSeeder::class);

        // $this->call(AddressSeeder::class);

>>>>>>> 6cd1930dc1ab7a1af2cb8189e3c6cf5ce16b2de9
    }
}
