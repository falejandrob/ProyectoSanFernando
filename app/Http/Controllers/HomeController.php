<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fechaActual = Carbon::now();
        $closestDate = FechaMaximaPedido::closestToDate()->first();
        $expectedDate = date("Y-m-d");
        $expectedTime = date("H:i");

        $productos = Producto::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        if (auth()->user()->hasRole('profesor')) {
            return view('home', ["productos" => $productos, "presupuesto" => $presupuesto, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime, 'closestDate' => $closestDate, 'fechaActual' => $fechaActual]);
        }

        if (auth()->user()->hasRole('admin')) {
            return view('admin.home');
        }

    }

    public function misPedidos($idUser)
    {
        $pedidos = getAllCarts(Auth::id());
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        return view("profesor.misPedidos", ["pedidos" => $pedidos, "presupuesto" => $presupuesto]);
    }

    public function detallesPedido($idPedido)
    {
        $pedido = getCart($idPedido);
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        if (auth()->user()->hasRole('profesor')) {
            return view("profesor.detallesPedido", ["pedido" => $pedido, "presupuesto" => $presupuesto, "idPedido" => $idPedido]);
        }

    }

    public function detallesPedidoAdmin($idPedido, $profesor)
    {
        $pedido = getCart($idPedido);
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();


        if (auth()->user()->hasRole('admin')) {
            return view("admin.detalles-pedido", ["pedido" => $pedido, "idPedido" => $idPedido, "profesor" => $profesor]);
        }


    }

    public function totalPedidos()
    {
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();
        return view("admin.pedidos", ["pedidos" => $pedidos, "profesores" => $profesores]);
    }

    public function addJustificacion(Request $request)
    {
        $justificacion = Session::get("justificacion");
        $justificacion = $justificacion . "\n" . $request->justificacion;
        Session::put("justificacion", $justificacion);


        return redirect()->action([HomeController::class, 'index']);
    }

}

/**
 * @return array|array[]
 *
 */
function getAllCartsTeachers()
{


    $allShopingCarts = [];
    $pedidos = Pedido::all();

    foreach ($pedidos as $pedido) {
        $cartCollection = collect();
        $idUserPedido = $pedido->idUser;
        $idPedido = $pedido->id;
        $datePedido = $pedido->fechaPedido;
        $expectedDateTime = $pedido->fechaPrevistaPedido;
        $expectedDate = Carbon::parse($expectedDateTime)->format('d-m-Y');
        $expectedTime = Carbon::parse($expectedDateTime)->format('H:i:s');
        $justification = $pedido->justificacion;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $itemPedido) {
            $product = Producto::findOrFail($itemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $itemPedido->cantidad;
            $observacion = $itemPedido->observaciones;

            $cartItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                'expectedDate' => $expectedDate,
                'expectedTime' => $expectedTime,
                'justification' => $justification,
                'fechaPedido' => $datePedido,
                'observacion'=>$observacion
            ]);

            $cartItem->setQuantity($quantity);
            $cartCollection->put($cartItem->rowId, $cartItem);
        }
        $allShopingCarts[$idPedido] = [$cartCollection, $idUserPedido];

    }
    return $allShopingCarts;
}


/**
 * Get all elements for the Pedidos table  asocciate with a User id
 *
 * @param $identifier
 * @return array
 */
function getAllCarts($identifier)
{


    $allShopingCarts = collect();
    $pedidos = Pedido::where('idUser', $identifier)->get();

    foreach ($pedidos as $pedido) {
        $cartCollection = collect();

        $idPedido = $pedido->id;
        $datePedido = $pedido->fechaPedido;
        $expectedDateTime = $pedido->fechaPrevistaPedido;
        $expectedDate = Carbon::parse($expectedDateTime)->format('d-m-Y');
        $expectedTime = Carbon::parse($expectedDateTime)->format('H:i:s');
        $justification = $pedido->justificacion;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $itemPedido) {
            $product = Producto::findOrFail($itemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $itemPedido->cantidad;
            $observacion = $itemPedido->observaciones;

            $carItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                'expectedDate' => $expectedDate,
                'expectedTime' => $expectedTime,
                'justification' => $justification,
                'fechaPedido' => $datePedido,
                'observacion'=>$observacion
            ]);

            $carItem->setQuantity($quantity);
            $cartCollection->put($carItem->rowId, $carItem);
        }
        $allShopingCarts->put($pedido->id, $cartCollection);
    }


    return $allShopingCarts;

}

/**
 * Get a specific element of the Pedidos table and his associates rows
 *
 * @param $identifier
 * @return mixed
 */
function getCart($identifier)
{
    $allShopingCarts = collect();

    $pedido = Pedido::where('id', $identifier)->first();

    $idPedido = $pedido->id;
    $datePedido = $pedido->fechaPedido;
    $expectedDateTime = $pedido->fechaPrevistaPedido;
    $expectedDate = Carbon::parse($expectedDateTime)->format('d-m-Y');
    $expectedTime = Carbon::parse($expectedDateTime)->format('H:i:s');
    $justification = $pedido->justificacion;

    $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

    foreach ($itemsPedido as $itemPedido) {
        $product = Producto::findOrFail($itemPedido->idProducto);
        $productId = $product->id;
        $productName = $product->nombre;
        $quantity = $itemPedido->cantidad;
        $observacion = $itemPedido->observaciones;
       // dd($itemPedido);
        $carItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
            'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
            'expectedDate' => $expectedDate,
            'expectedTime' => $expectedTime,
            'justification' => $justification,
            'fechaPedido' => $datePedido,
            'observacion'=>$observacion
        ]);

        $carItem->setQuantity($quantity);
        $allShopingCarts->put($carItem->rowId, $carItem);
    }

    return $allShopingCarts;
}


