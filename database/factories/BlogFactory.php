<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;
use App\Models\Trabajador;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trabajador_id' => Trabajador::factory(),
            'titulo' => fake()->sentence(),
            'subtitulo' => fake()->sentence(),
            'contenido' => fake()->paragraphs(3, true),
            'imagen' => 'imagesBlog/blog-' . fake()->numberBetween(1, 5) . '.jpg',
        ];
    }
}