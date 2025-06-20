<?php

namespace Database\Seeders;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('local')->deleteDirectory('profile-photos');
        Storage::disk('local')->deleteDirectory('livewire-tmp');
        Storage::disk('local')->deleteDirectory('model_images');

        Storage::disk('local')->makeDirectory('profile-photos');
        Storage::disk('local')->makeDirectory('livewire-tmp');
        Storage::disk('local')->makeDirectory('model_images');

        @chmod(Storage::disk('local')->path('model_images'), 0755);
        @chmod(Storage::disk('local')->path('profile-photos'), 0755);
        @chmod(Storage::disk('local')->path('livewire-tmp'), 0755);

        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ModelImageSeeder::class);
        $this->call(AddressTypeSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderProductSeeder::class);
        $this->call(MessageTypeSeeder::class);
        $this->call(MessageSeeder::class);
    }
}
