<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EntregaProducto>
 */
class EntregaProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idProveedores' => $this->faker->randomElement(DB::table('proveedores')->pluck('id')),
            'idPedido' => $this->faker->randomElement(DB::table('pedidos')->pluck('id')),
            'idProfesor' => $this->faker->randomElement(DB::table('users')->pluck('id')),
            'cantidad' => $this->faker->randomFloat(2, 0.0, 20.0),
            'importe' => $this->faker->randomFloat(2, 0.0, 200.0),
            'iva' =>21,
            'importeIva' => $this->faker->randomFloat(2, 0.0, 400.0),
        ];
    }
}
