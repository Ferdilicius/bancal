<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('model_images');
        Storage::disk('public')->deleteDirectory('profile-photos');
        Storage::disk('private')->deleteDirectory('livewire-tmp');

        Storage::disk('public')->makeDirectory('model_images');
        Storage::disk('public')->makeDirectory('profile-photos');
        Storage::disk('private')->makeDirectory('livewire-tmp');

        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ModelImageSeeder::class);
        $this->call(AddressTypeSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PayMethodSeeder::class);
    }
}
