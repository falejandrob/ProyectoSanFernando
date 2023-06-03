<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido;
use App\Models\LineaPedido;
use App\Models\Producto;
use App\Models\Categoria;

class InformesController extends Controller
{
    public function informes()
    {
        // Productos más pedidos
        $lineasPedido = LineaPedido::all();
        $labelsProductos = [];
        $dataProductos = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsProductos); $i++) {
                if ($labelsProductos[$i] === Producto::find($linea->idProducto)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataProductos[$indice] += $linea->cantidad;
            } else {
                $labelsProductos[] = Producto::find($linea->idProducto)->nombre;
                $dataProductos[] = $linea->cantidad;
            }
        }

        // Categorias más pedidas
        $labelsCategorias = [];
        $dataCategorias = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsCategorias); $i++) {
                if ($labelsCategorias[$i] === Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataCategorias[$indice] += $linea->cantidad;
            } else {
                $labelsCategorias[] = Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre;
                $dataCategorias[] = $linea->cantidad;
            }
        }

        return view('admin.informes', ["labelsProductos" => $labelsProductos, "dataProductos" => $dataProductos, "labelsCategorias" => $labelsCategorias, "dataCategorias" => $dataCategorias]);
    }

    public function informesProfesor()
    {
        $profesores = User::all();
        $user = "";

        $labelsProductos = [];
        $dataProductos = [];
        $labelsCategorias = [];
        $dataCategorias = [];

        return view('admin.informesProfesor', ["user" => $user, "profesores" => $profesores, "labelsProductos" => $labelsProductos, "dataProductos" => $dataProductos, "labelsCategorias" => $labelsCategorias, "dataCategorias" => $dataCategorias]);
    }

    public function informesProfesorResultado(Request $request)
    {
        $user = User::find($request->user)->nombre;
        $profesores = User::all();

        // Productos más pedidos según profesor
        $pedidos = Pedido::where('idUser', $request->user)->get();
        $pedidosId = [];

        foreach($pedidos as $pedido) {
            array_push($pedidosId, $pedido->id);
        }

        $lineasPedido = LineaPedido::whereIn('idPedido', $pedidosId)->get();
        $labelsProductos = [];
        $dataProductos = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsProductos); $i++) {
                if ($labelsProductos[$i] === Producto::find($linea->idProducto)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataProductos[$indice] += $linea->cantidad;
            } else {
                $labelsProductos[] = Producto::find($linea->idProducto)->nombre;
                $dataProductos[] = $linea->cantidad;
            }
        }

        // Categorias más pedidas
        $labelsCategorias = [];
        $dataCategorias = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsCategorias); $i++) {
                if ($labelsCategorias[$i] === Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataCategorias[$indice] += $linea->cantidad;
            } else {
                $labelsCategorias[] = Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre;
                $dataCategorias[] = $linea->cantidad;
            }
        }

        return view('admin.informesProfesor', ["user" => $user, "profesores" => $profesores, "labelsProductos" => $labelsProductos, "dataProductos" => $dataProductos, "labelsCategorias" => $labelsCategorias, "dataCategorias" => $dataCategorias]);
    }

    public function informesMes()
    {
        $meses = [
            [1, 'Enero'],
            [2, 'Febrero'],
            [3, 'Marzo'],
            [4, 'Abril'],
            [5, 'Mayo'],
            [6, 'Junio'],
            [7, 'Julio'],
            [8, 'Agosto'],
            [9, 'Septiembre'],
            [10, 'Octubre'],
            [11, 'Noviembre'],
            [12, 'Diciembre']
        ];
        $month = "";

        $labelsProductos = [];
        $dataProductos = [];
        $labelsCategorias = [];
        $dataCategorias = [];

        return view('admin.informesMes', ["month" => $month, "meses" => $meses, "labelsProductos" => $labelsProductos, "dataProductos" => $dataProductos, "labelsCategorias" => $labelsCategorias, "dataCategorias" => $dataCategorias]);
    }

    public function informesMesResultado(Request $request)
    {
        $meses = [
            [1, 'Enero'],
            [2, 'Febrero'],
            [3, 'Marzo'],
            [4, 'Abril'],
            [5, 'Mayo'],
            [6, 'Junio'],
            [7, 'Julio'],
            [8, 'Agosto'],
            [9, 'Septiembre'],
            [10, 'Octubre'],
            [11, 'Noviembre'],
            [12, 'Diciembre']
        ];
        $month = $request->month;
        $monthNombre = "";

        foreach($meses as $mes) {
            if($mes[0] == $month) {
                $monthNombre = $mes[1];
            }
        }

        // Productos más pedidos el mes
        $pedidosTodos = Pedido::all();
        $pedidosId = [];

        foreach($pedidosTodos as $pedido) {
            $fecha = intval(date("m", strtotime($pedido->fechaPedido)));
            if($fecha == $month) {
                array_push($pedidosId, $pedido->id);
            }
        }

        $lineasPedido = LineaPedido::whereIn('idPedido', $pedidosId)->get();
        $labelsProductos = [];
        $dataProductos = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsProductos); $i++) {
                if ($labelsProductos[$i] === Producto::find($linea->idProducto)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataProductos[$indice] += $linea->cantidad;
            } else {
                $labelsProductos[] = Producto::find($linea->idProducto)->nombre;
                $dataProductos[] = $linea->cantidad;
            }
        }

        // Categorias más pedidas según el mes
        $labelsCategorias = [];
        $dataCategorias = [];

        foreach($lineasPedido as $linea) {
            $indice = -1;
            for ($i = 0; $i < count($labelsCategorias); $i++) {
                if ($labelsCategorias[$i] === Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre) {
                    $indice = $i;
                    break;
                }
            }
        
            if ($indice !== -1) {
                $dataCategorias[$indice] += $linea->cantidad;
            } else {
                $labelsCategorias[] = Categoria::find(Producto::find($linea->idProducto)->idCategoria)->nombre;
                $dataCategorias[] = $linea->cantidad;
            }
        }

        return view('admin.informesMes', ["month" => $month, "meses" => $meses, "monthNombre" => $monthNombre, "labelsProductos" => $labelsProductos, "dataProductos" => $dataProductos, "labelsCategorias" => $labelsCategorias, "dataCategorias" => $dataCategorias]);
    }
}
