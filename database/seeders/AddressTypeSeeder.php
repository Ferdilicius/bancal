<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AddressType;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressType::create(['name' => 'Bancal']);
        AddressType::create(['name' => 'Huerto urbano compartido']);
        AddressType::create(['name' => 'Huerto urbano privado']);
        AddressType::create(['name' => 'Huerto escolar']);
    }
}
