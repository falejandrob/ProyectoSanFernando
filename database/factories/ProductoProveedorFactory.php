<?php

namespace Database\Factories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductoProveedor>
 */
class ProductoProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pedido' => $this->faker->randomElement(DB::table('pedidos')->pluck('id')),
            'lineaPedido' => $this->faker->randomElement(DB::table('linea_pedidos')->pluck('id')),
            'proveedor' => $this->faker->randomElement(DB::table('proveedores')->pluck('id')),
        ];
    }
}
