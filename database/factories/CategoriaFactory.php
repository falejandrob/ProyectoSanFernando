<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->getCategoriaFromSql()
        ];
    }

    private function getCategoriaFromSql(): string
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

        $categoria = DB::table('categorias')->whereIn('nombre', $categorias)->first();

        return $categoria ? $categoria->nombre : '';
    }
}
