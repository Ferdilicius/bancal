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
        Storage::disk('local')->deleteDirectory('livewire-tmp');

        Storage::disk('public')->makeDirectory('model_images');
        Storage::disk('public')->makeDirectory('profile-photos');
        Storage::disk('local')->makeDirectory('livewire-tmp');

        @chmod(Storage::disk('public')->path('model_images'), 0777);
        @chmod(Storage::disk('public')->path('profile-photos'), 0777);
        @chmod(Storage::disk('local')->path('livewire-tmp'), 0777);

        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ModelImageSeeder::class);
        $this->call(AddressTypeSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PayMethodSeeder::class);
    }
}
