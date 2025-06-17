<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModelImage;
use App\Models\Product;

class ModelImageSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $count = rand(1, 3);
            for ($i = 1; $i <= $count; $i++) {
                ModelImage::factory()->create([
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                    'order' => $i,
                ]);
            }
        }
    }
}
