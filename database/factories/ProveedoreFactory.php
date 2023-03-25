<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedore>
 */
class ProveedoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proveedores = array("provecaex", "spar", "cerrato perez");
        return [
            'nombre' => $this->faker->randomElement($proveedores)
        ];
    }
}
