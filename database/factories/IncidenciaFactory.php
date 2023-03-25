<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $incidencia = array('Producto no suficientemente especificado', 'No se encuentra en el mercado para la fecha de recogida', 'El producto no se considera como necesario en la elaboracion indicada en la programacion del modulo','La cantidad solicitada no se ajusta a la elaboracion señalada y/o al numero de raciones', 'Otros');
        $respuesta = array('Remitir el listado de los productos con mayor informacion', 'Especificar un producto alternativo', 'Reunion con el responsable de los pedidos/economato para razonar dicho pedido');
        return [
            'idPedido' => $this->faker->randomElement(DB::table('pedidos')->pluck('id')),
            'incidencia' =>$this->faker->randomElement($incidencia),
            'respuesta' => $this->faker->randomElement($respuesta),
        ];
    }
}
