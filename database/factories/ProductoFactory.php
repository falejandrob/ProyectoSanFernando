<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productos = array("pollo", "leche", "salmón", "espinacas", "naranjas", "almendras",
            "tomate frito", "mortadela", "garbanzos", "gambas congeladas");
        $validacion = random_int(0,1);
        return [
            'nombre' => $this->faker->randomElement($productos),
            'validado' => $validacion,
            'idCategoria' => $this->faker->randomElement(DB::table('categorias')->pluck('id')),
        ];
    }
}
