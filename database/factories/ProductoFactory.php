<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['Medicamentos', 'Vitaminas', 'Cuidado Personal', 'Primeros Auxilios', 'Suplementos'];
        
        return [
            'titulo' => fake()->words(3, true),
            'categoria' => fake()->randomElement($categorias),
            'descripcion' => fake()->paragraphs(2, true),
            'imagen' => 'imagesProductos/producto-' . fake()->numberBetween(1, 5) . '.jpg',
        ];
    }
}