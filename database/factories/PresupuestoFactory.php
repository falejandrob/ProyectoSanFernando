<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presupuesto>
 */
class PresupuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUser' => $this->faker->randomElement(DB::table('users')->pluck('id')),
            'anio' => $this->faker->year,
            'presupuestoTotal' => $this->faker->numberBetween(3500, 4000),
        ];
    }
}
