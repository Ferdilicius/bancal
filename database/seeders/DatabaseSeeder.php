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
        $this->call(AddressTypeSeeder::class);

        $this->call(AddressSeeder::class);
=======
>>>>>>> 6684643ade7598efa8bbdbf04b4ec01d8a30c251
    }
}
