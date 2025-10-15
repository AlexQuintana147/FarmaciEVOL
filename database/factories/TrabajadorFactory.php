<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Trabajador;

class TrabajadorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trabajador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
            'nombre_completo' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'dni' => fake()->unique()->numerify('########'),
            'remember_token' => Str::random(10),
        ];
    }
}