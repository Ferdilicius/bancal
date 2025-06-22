<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModelImageFactory extends Factory
{
    public function definition()
    {
        $testImagesPath = storage_path('app/public/product-images-test');
        $files = glob($testImagesPath . '/*.*');

        if (empty($files)) {
            throw new \RuntimeException("No test images found in {$testImagesPath}");
        }
        $randomImage = $files[array_rand($files)];

        $storagePath = storage_path('app/private/model_images');

        $filename = uniqid() . '_' . basename($randomImage);
        copy($randomImage, $storagePath . '/' . $filename);

        return [
            'path' => $filename,
        ];
    }
}
