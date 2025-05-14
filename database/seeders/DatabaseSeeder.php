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

        $this->call(AddressTypeSeeder::class);

        $this->call(AddressSeeder::class);
    }
}
