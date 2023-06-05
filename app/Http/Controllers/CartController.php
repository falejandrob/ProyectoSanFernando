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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;

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
        $fechaConFormato = date('d/m/Y', strtotime($request->expectedDate));
        $pedido = $this->buildOrderDetails($request, $fechaConFormato);

        $this->sendOrder($pedido, $request->expectedTime, $fechaConFormato);

        store(Auth::id());
        Cart::destroy();
        session()->flash('success', 'El pedido se ha realizado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }

    private function buildOrderDetails(Request $request, string $fechaConFormato)
    {
        $pedido = [];

        foreach (Cart::content() as $item) {
            $producto = Producto::findOrFail($item->id);
            $pedido[] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'categoria' => Categoria::findOrFail($producto->idCategoria)->nombre,
                'expectedDate' => $fechaConFormato,
                'expectedTime' => $request->expectedTime,
                'justification' => $request->justification,
                'fechaPedido' => Carbon::now()->format('d-m-Y'),
                'observacion' => $request->input('observacion-' . $item->rowId, null)
            ];

            Cart::update($item->rowId, ['options' => $pedido[count($pedido) - 1]]);
        }

        return $pedido;
    }

    private function sendOrder(array $pedido, string $horaEsperada, string $fechaEsperada)
    {
        $email = Auth::user()->email;
        $nombre = Auth::user()->nombre;
        $apellido = Auth::user()->apellido;

        Mail::send([], [], function ($message) use ($nombre, $apellido, $email, $pedido, $fechaEsperada, $horaEsperada) {
            $message->to($email, "$nombre $apellido")
                ->subject('Confirmación de pedido')
                ->html($this->formatOrderHTML($pedido, $fechaEsperada, $horaEsperada));
        });
    }

    private function formatOrderHTML(array $pedido, string $fechaEsperada, string $horaEsperada)
    {
        $nombre = Auth::user()->nombre;
        $apellido = Auth::user()->apellido;

        $formattedPedido = "<div style='font-family: Arial, sans-serif;'>
                            <h2>Estimado/a $nombre $apellido,</h2>
                            <p>Agradecemos tu preferencia. Tu pedido se ha procesado correctamente. A continuación, encontrarás el resumen:</p>
                            <hr>
                            <h3>Detalles del Pedido:</h3>
                            <p><strong>Fecha esperada de entrega:</strong> $fechaEsperada</p>
                            <p><strong>Hora esperada de entrega:</strong> $horaEsperada</p><br>";

        foreach ($pedido as $item) {
            $observacion = $item['observacion'] ? $item['observacion'] : 'N/A';
            $formattedPedido .= "<div style='margin-bottom:20px;'>
                                <p><strong>Producto:</strong> {$item['nombre']}</p>
                                <p><strong>Categoría:</strong> {$item['categoria']}</p>
                                <p><strong>Observaciones:</strong> $observacion</p>
                             </div><hr>";
        }

        $formattedPedido .= "<p>Si tienes alguna pregunta o si necesitas asistencia con tu pedido, por favor, no dudes en responder a este correo electrónico.</p>
                         <p>Valoramos tu confianza en nuestros servicios.</p>
                         <p style='margin-bottom: 50px;'>Saludos cordiales,</p>
                         <p><strong>El Equipo de EconoMando</strong></p>
                         <hr>
                         <p style='font-size:0.8em;color:#777;'>Este es un correo electrónico automático, por favor no responder directamente a este mensaje.</p>
                        </div>";

        return $formattedPedido;
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

    $expectedDate = Cart::content()->first()->options->expectedDate;
    $expectedTime = Cart::content()->first()->options->expectedTime;

    $fechaPrevista = Carbon::createFromFormat('d/m/Y H:i', $expectedDate.' '.$expectedTime);

    $fechaPrevista->format('Y-m-d H:i:s');

    $pedido = new Pedido();

    $pedido->idUser = $identifier;
    $pedido->identificador = generarCodigo();
    $pedido->fechaPedido = Carbon::now();
    $pedido->fechaPrevistaPedido = $fechaPrevista;
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
    $pedido->validado = 0;
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


function obtenerCodigo(){

    $codigo = "";

    $maxCodigo = DB::table('pedidos')
        ->where('idUser', '=', Auth::id())
        ->max('identificador');

    $c = substr($maxCodigo, 4, 4);

    if ($c == "" or $c == "9999") {
        $codigo = "0001";
    } else {
        $indice = intval($c) + 1;

        if ($indice >= 10 and $indice < 100) {
            $codigo = "00" . $indice;
        } elseif ($indice >= 100 and $indice < 1000) {
            $codigo =  "0" . $indice;
            dd($codigo);
        } elseif ($indice >= 1000 and $indice < 10000) {
            $codigo =  $indice;
        }
        else {
            $codigo = "000" . $indice;
        }
    }

    return $codigo;

}


function generarCodigo(){

    $cod = obtenerCodigo();

    $nombre = auth()->user()->nombre;
    $apellidos = auth()->user()->apellidos;

    $subInicial1 = substr($nombre, 0, 1);
    $subInicial2 = substr($apellidos, 0, 1);

    $lengthApellidos = strlen($apellidos);

    $apellido2 = "";
    $pos = 0;

    for ($i = 0; $i < $lengthApellidos; $i++) {
        if($apellidos[$i] == " "){
            $pos = 1;
        }
        if($pos == 1){
            $apellido2 = $apellido2 . $apellidos[$i];
        }
    }

    $subInicial3 = substr($apellido2, 1, 1);

    $anio = date('Y');

    $codigo = $anio . $cod . strtoupper($subInicial1) . strtoupper($subInicial2) . strtoupper($subInicial3);

    return $codigo;

}
