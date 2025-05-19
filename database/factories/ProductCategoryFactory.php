<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => array_shift($this->productCategoryNames)
        ];
    }
}

