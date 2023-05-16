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
        $proveedores = array("Alimex",
            "Benibelmar",
            "Carnicería Cipri",
            "Congelados Suroeste",
            "Delta cafés",
            "Dicomba",
            "Dúo harinero",
            "Fripan",
            "Granja El Cruce",
            "Hosuni",
            "Panadería J.J.",
            "Pedro",
            "Provecaex",
            "Puratos T500",
            "Sosa",
            "Sumin. Badajoz",
        );
        return [
            'nombre' => $this->faker->randomElement($proveedores)
        ];
    }
}
