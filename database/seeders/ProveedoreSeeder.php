<?php

namespace Database\Seeders;

use App\Models\Proveedore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        foreach ($proveedores as $proveedor){
            Proveedore::factory()->create(['nombre'=> $proveedor]);
        }
    }
}
