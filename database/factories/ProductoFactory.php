<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */


class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Leer el archivo CSV y obtener los datos en forma de DataTable
        $csvPath = base_path('ScriptsSQL/Listado mmpp proyecto.csv');
        $dataTable = $this->readCSV($csvPath);

        // Agrupar los datos por categoría
        $categorias = $dataTable->groupBy('Familia');

        // Inicializar el arreglo de productos asociados a una categoría
        $productosPorCategoria = [];

        // Iterar por cada categoría y asociar los productos a ella
        foreach ($categorias as $categoria => $productos) {
            foreach ($productos as $producto) {
                $productosPorCategoria[$categoria][] = $producto['Articulo'];
            }
        }

        // Obtener la lista de categorías y eliminar las que no tienen productos
        $categorias = array_filter(array_keys($productosPorCategoria));

        // Si no quedan categorías, lanzar una excepción
        if (empty($categorias)) {
            throw new Exception('No hay categorías con productos disponibles en el archivo CSV');
        }

        // Obtener la primera categoría de la lista y asociarle un producto
        $categoria = array_shift($categorias);
        $productos = array_shift($productosPorCategoria[$categoria]);


        return [
            'nombre' => $productos,
            'validado' => 1,
            'idCategoria' => DB::table('categorias')->where('nombre', $categoria)->value('id'),
        ];
    }

    /**
     * Leer un archivo CSV y devolver los datos como DataTable.
     *
     * @param string $filePath Ruta del archivo CSV
     * @return \Illuminate\Support\Collection
     */
    private function readCSV(string $filePath): \Illuminate\Support\Collection
    {
        $data = \Illuminate\Support\Facades\File::get($filePath);
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

