<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Confirm the request of the order
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $fecha = strtotime($request->expectedDate);
        $fechaConFormato = date('d/m/Y', $fecha);
        foreach (Cart::content() as $item) {
            $producto = Producto::findOrFail($item->id);
            $observacion = $request->input('observacion-' . $item->rowId, null);
            Cart::update($item->rowId, ['options' => [
                'categoria' => Categoria::findOrFail($producto->idCategoria)->nombre,
                'expectedDate' => $fechaConFormato,
                'expectedTime' => $request->expectedTime,
                'justification' => $request->justification,
                'fechaPedido' => Carbon::now()->format('d-m-Y'),
                'observacion' => $observacion
            ]]);
        }
        Session::forget("justificacion");
        $dateTimeJustification = [
            'expectedDate' => Carbon::parse($request->expectedDate)->format('d/m/Y'),
            'expectedTime' => $request->expectedTime,
            'justification' => $request->justification,
        ];
        $productos = Cart::content();

        store(Auth::id());
        Cart::destroy();
        session()->flash('success', 'El pedido se ha realizado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }

    /**
     * Delete an order
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    function eliminarPedido($id)
    {
        $pedido = Pedido::find($id);
        $pedido->eliminado = "1";
        $pedido->save();
        session()->flash('success', 'El pedido se ha eliminado correctamente.');
        return redirect()->action([HomeController::class, 'totalPedidos']);
    }

    /**
     * Delete an order
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function eliminarPedidoProfesor($id)
    {
        $pedido = Pedido::find($id);
        $pedido->eliminado = "1";
        $pedido->save();
        session()->flash('success', 'El pedido se ha eliminado correctamente.');
        return redirect()->action([HomeController::class, 'misPedidos'], [Auth::id()]);
    }

    /**
     * Repeat an order
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    function repetirPedido($id)
    {
        if (Cart::content()) {
            Cart::destroy();
        }

        $pedido = Pedido::where('id', $id)->first();


        $idPedido = $pedido->id;
        $datePedido = $pedido->fechaPedido;
        $expectedDateTime = $pedido->fechaPrevistaPedido;
        $expectedDate = Carbon::parse($expectedDateTime)->format('d/m/Y');
        $expectedTime = Carbon::parse($expectedDateTime)->format('H:i');
        $justification = $pedido->justificacion;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $ItemPedido) {
            $product = Producto::findOrFail($ItemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $ItemPedido->cantidad;
            Cart::add(['id' => $productId,
                'qty' => $quantity,
                'name' => $productName,
                'price' => 0.0,
                'weight' => 0.0,
                'options' => [
                    'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                    'expectedDate' => $expectedDate,
                    'expectedTime' => $expectedTime,
                    'justification' => $justification,
                    'fechaPedido' => $datePedido
                ]]);

        }

        return redirect()->action([HomeController::class, 'realizarPedido']);

    }

    function modificarPedido($id)
    {
        if (Cart::content()) {
            Cart::destroy();
        }

        $pedido = Pedido::where('id', $id)->first();

        $idPedido = $pedido->id;
        $datePedido = $pedido->fechaPedido;
        $expectedDateTime = $pedido->fechaPrevistaPedido;
        $expectedDate = explode(" ", $pedido->fechaPrevistaPedido)[0];
        $expectedTime = explode(" ", $pedido->fechaPrevistaPedido)[1];
        $justification = $pedido->justificacion;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $ItemPedido) {
            $product = Producto::findOrFail($ItemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $ItemPedido->cantidad;
            Cart::add(['id' => $productId,
                'qty' => $quantity,
                'name' => $productName,
                'price' => 0.0,
                'weight' => 0.0,
                'options' => [
                    'id' => $idPedido,
                    'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                    'expectedDate' => $expectedDate,
                    'expectedTime' => $expectedTime,
                    'justification' => $justification,
                    'fechaPedido' => $datePedido
                ]]);
        }
        $fechaActual = Carbon::now();
        $closestDate = FechaMaximaPedido::closestToDate()->first();

        $productos = Producto::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        return view("profesor.modificarPedido", ["idPedido" => $idPedido, "productos" => $productos, "presupuesto" => $presupuesto, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime, 'closestDate' => $closestDate, 'fechaActual' => $fechaActual]);
    }

    public function modify(Request $request, $idPedido)
    {
        $fecha = strtotime($request->expectedDate);
        $fechaConFormato = date('d-m-Y', $fecha);

        foreach (Cart::content() as $item) {
            $producto = Producto::findOrFail($item->id);
            $observacion = $request->input('observacion-' . $item->rowId, null);
            Cart::update($item->rowId, ['options' => [
                'categoria' => Categoria::findOrFail($producto->idCategoria)->nombre,
                'expectedDate' => $fechaConFormato,
                'expectedTime' => $request->expectedTime,
                'justification' => $request->justification,
                'fechaPedido' => Carbon::now()->format('d-m-Y'),
                'observacion' => $observacion
            ]]);
        }
        
        Session::forget("justificacion");
        $dateTimeJustification = [
            'expectedDate' => Carbon::parse($request->expectedDate)->format('d/m/Y'),
            'expectedTime' => $request->expectedTime,
            'justification' => $request->justification,
        ];
        $productos = Cart::content();

        mod(Auth::id(), $idPedido);
        Cart::destroy();
        session()->flash('success', 'El pedido se ha modificado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }
}

/**
 * Save an order in the database serialized
 *
 * @param $identifier
 * @return void
 */
function store($identifier)
{
    $pedido = new Pedido();

    $pedido->idUser = $identifier;
    $pedido->fechaPedido = Carbon::now();
    $pedido->fechaPrevistaPedido = Carbon::parse(Cart::content()->first()->options->expectedDate . Cart::content()->first()->options->expectedTime);
    $pedido->justificacion = Cart::content()->first()->options->justification;
    $pedido->estaPedido = true;
    $pedido->save();

    foreach (Cart::content() as $cartItem) {
        $pedidoItem = new LineaPedido();
        $pedidoItem->idPedido = $pedido->id;
        $pedidoItem->idProducto = $cartItem->id;
        $pedidoItem->cantidad = $cartItem->qty;
        $pedidoItem->observaciones = $cartItem->options->observacion;
        $pedidoItem->save();
    }
}

function mod($identifier, $idPedido)
{
    $pedido = Pedido::find($idPedido);

    $pedido->fechaPedido = Carbon::now();
    $pedido->fechaPrevistaPedido = Carbon::parse(Cart::content()->first()->options->expectedDate . Cart::content()->first()->options->expectedTime);
    $pedido->justificacion = Cart::content()->first()->options->justification;
    $pedido->estaPedido = true;
    $pedido->save();

    $lineasAnteriores = LineaPedido::where('idPedido', $idPedido)->get();
    
    foreach($lineasAnteriores as $linea) {
        $linea->delete();
    }

    foreach (Cart::content() as $cartItem) {
        $pedidoItem = new LineaPedido();
        $pedidoItem->idPedido = $pedido->id;
        $pedidoItem->idProducto = $cartItem->id;
        $pedidoItem->cantidad = $cartItem->qty;
        $pedidoItem->observaciones = $cartItem->options->observacion;
        $pedidoItem->save();
    }
}
