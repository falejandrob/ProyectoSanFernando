<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            'anio' => Carbon::now()->year + rand(-2, 2),
            'presupuestoTotal' => $this->faker->numberBetween(3500, 4000),
        ];
    }
}
