<?php

namespace Database\Seeders;

use App\Models\Producto;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leer el archivo CSV y obtener los datos en forma de DataTable
        $csvPath = base_path('ScriptsSQL/Listado mmpp proyecto.csv');
        $dataTable = $this->readCSV($csvPath);

        foreach ($dataTable as $producto) {
            //dd($producto);
            Producto::factory()->create([
                'nombre' => $producto['Articulo'],
                'validado' => 0,
                'idCategoria' => DB::table('categorias')->where('nombre', $producto['Familia'])->value('id'),
                ]);
        }

    }
    /**
     * Leer un archivo CSV y devolver los datos como DataTable.
     *
     * @param string $filePath Ruta del archivo CSV
     * @return \Illuminate\Support\Collection
     */
    private function readCSV(string $filePath): Collection
    {
        $data = File::get($filePath);
        $lines = explode("\n", $data);

        $headers = str_getcsv(array_shift($lines));
        $dataTable = collect();

        foreach ($lines as $line) {
            if (!empty($line)) {
                $row = str_getcsv($line);
                $dataTable->push(collect($headers)->combine($row));
            }
        }

        return $dataTable;
    }
}
