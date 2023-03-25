<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $observaciones = ["Necesito que sea del mercadona", "Quiero que sea fresco", "No me importa el proveedor"];
        $justificaciones = ["Hacer una tarta", "Hacer una sopa", "Hacer un menú de primero y segundo"];

        return [
            'idUser' => $this->faker->randomElement(DB::table('users')->pluck('id')),
            'fechaPedido' => $this->faker->dateTimeThisMonth,
            'fechaPrevistaPedido' => $this->faker->dateTimeThisMonth,
            'observaciones' => $this->faker->randomElement($observaciones),
            'justificacion' => $this->faker->randomElement($justificaciones),
        ];
    }
}
