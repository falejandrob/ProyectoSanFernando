<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Carnes, Aves, Embutidos',
            'Aceite, Grasa',
            'Bases cocina',
            'Bebidas',
            'Condim, Espec, Hierbas',
            'Conservas',
            'Consumibles',
            'Frutas, Frutos Secos',
            'Hortalizas',
            'Huevos',
            'Lacteos y derivados',
            'Pastas Alimenticias',
            'Legumb, Cereal, Pan, Boller',
            'Pastelería',
            'Pescados, Mariscos',
            'Cafés, Infus',
        ];

        foreach ($categorias as $categoria) {
            Categoria::factory()->create(['nombre' => $categoria]);
        }
    }
}
