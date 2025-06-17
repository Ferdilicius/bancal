<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModelImageFactory extends Factory
{
    public function definition()
    {
        // Ruta de la carpeta de imágenes de prueba
        $testImagesPath = storage_path('app/public/product-images-test');
        $files = glob($testImagesPath . '/*.*');

        // Selecciona una imagen aleatoria solo si hay archivos disponibles
        if (empty($files)) {
            throw new \RuntimeException("No test images found in {$testImagesPath}");
        }
        $randomImage = $files[array_rand($files)];

        // Copia la imagen a storage/app/public/model_images
        $storagePath = storage_path('app/private/model_images');

        $filename = uniqid() . '_' . basename($randomImage);
        copy($randomImage, $storagePath . '/' . $filename);

        // Devuelve la ruta relativa para guardar en la base de datos
        return [
            'path' => 'model_images/' . $filename,
        ];
    }
}
