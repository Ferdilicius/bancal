<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoriaProducto>
 */
class ProductCategoryFactory extends Factory
{

    protected $productCategoryNames = [
        'Verduras',
        'Frutas',
        'Lácteos',
        'Cereales',
        'Carnes',
        'Enlatados',
        'Congelados'
    ];
    

    public function definition(): array
    {
        return [
            'nombre' => array_shift($this->productCategoryNames)
        ];
    }
}

