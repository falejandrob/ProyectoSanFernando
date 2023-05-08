<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FechaMaximaPedido>
 */
class FechaMaximaPedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'fechaMaxima'=>$this->faker->dateTimeBetween('now', '+1 year'),
            //'fechaVencida'=>$this->faker->randomNumber(0,1)
        ];
    }
}
