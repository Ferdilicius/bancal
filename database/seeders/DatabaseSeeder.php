<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Storage::deleteDirectory('public/storage');
        Storage::makeDirectory('public/storage');

        $this->call(UserSeeder::class);

        $this->call(ProductCategorySeeder::class);

        $this->call(ProductSeeder::class);

        $this->call(AddressTypeSeeder::class);

        $this->call(AddressSeeder::class);

        $this->call(PayMethodSeeder::class);
    }
}
