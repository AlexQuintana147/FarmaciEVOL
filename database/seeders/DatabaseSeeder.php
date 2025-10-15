<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trabajador;
use App\Models\Blog;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Crear 5 trabajadores
        $trabajadores = Trabajador::factory(5)->create();

        Trabajador::factory()->create([
            'usuario' => 'admin',
            'password' => bcrypt('admin123'),
            'nombre_completo' => 'Administrador',
            'apellidos' => 'Sistema',
            'dni' => '12345678',
        ]);
    }
}