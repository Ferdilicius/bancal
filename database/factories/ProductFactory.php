<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    protected $productNames = [
        'Zanahoria',
        'Tomate',
        'Lechuga',
        'Miel',
        'Mermelada de fresa',
        'Arándanos',
        'Espinaca',
        'Pimiento',
        'Cebolla',
        'Ajo',
        'Pera',
        'Manzana',
        'Naranja',
        'Banana',
        'Uvas',
        'Melón',
        'Sandía',
        'Kiwi',
        'Papaya',
        'Durazno',
        'Frambuesa',
        'Brócoli',
        'Coliflor',
        'Apio',
        'Rábanos',
        'Calabaza',
        'Pepino',
        'Albahaca',
        'Cilantro',
        'Perejil',
        'Tomillo',
        'Romero',
        'Fresas',
        'Cereza',
        'Granada',
        'Higos',
        'Mango',
        'Chirimoya',
        'Guayaba',
        'Maracuyá',
        'Lima',
        'Limón',
        'Mandarina',
        'Coco',
        'Almendras',
        'Nueces',
        'Avellanas',
        'Pistachos',
        'Anacardos'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement($this->productNames),
            'description' => $this->faker->sentence(6, true) . ' Fresco y de alta calidad, ideal para tu cocina.',
            'quantity' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 0.5, 20),
            'status' => $this->faker->randomElement([0, 1]),
            'user_id' => User::factory(),
        ];
    }
}
