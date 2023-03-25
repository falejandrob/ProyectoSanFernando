<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LineaPedido>
 */
class LineaPedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idPedido' => $this->faker->randomElement(DB::table('pedidos')->pluck('id')),
            'idProducto' => $this->faker->randomElement(DB::table('productos')->pluck('id')),
            'cantidad' => $this->faker->numberBetween(1, 15),
        ];
    }
}
