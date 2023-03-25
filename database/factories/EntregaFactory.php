<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrega>
 */
class EntregaFactory extends Factory
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
            'descripcion' => $this->faker->sentence(),
            'fecha'=>$this->faker->dateTimeBetween('now', '+1 year'),
            'foto'=>null,
        ];
    }
}
