<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = array("congelados", "conservas", "carnes", "pescados", "charcuteria",
            "frutas", "verduras", "legumbres", "lacteos y huevos", "frutos secos");

        return [
            'nombre' => $this->faker->randomElement($categorias)
        ];
    }
}
