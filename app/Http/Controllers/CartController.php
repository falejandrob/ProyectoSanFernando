<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\LineaPedido;
use App\Models\Pedido;
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
        Pedido::destroy($id);
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
        Pedido::destroy($id);
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
        $expectedDate = Carbon::parse($expectedDateTime)->format('d-m-Y');
        $expectedTime = Carbon::parse($expectedDateTime)->format('H:i:s');
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

        return redirect()->action([HomeController::class, 'index']);

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
        //dd(Cart::content());
        $pedidoItem->idPedido = $pedido->id;
        $pedidoItem->idProducto = $cartItem->id;
        $pedidoItem->cantidad = $cartItem->qty;
        $pedidoItem->observaciones = $cartItem->options->observacion;
        $pedidoItem->save();

    }
}

