<?php

namespace Database\Seeders;

use App\Models\Presupuesto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el número de usuarios existentes en la base de datos
        $numUsuarios = User::count();

        // Ejecutar el seeder por cada usuario
        for ($i = 1; $i <= $numUsuarios; $i++) {
            Presupuesto::factory()->create();
        }
    }
}
