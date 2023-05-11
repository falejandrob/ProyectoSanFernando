<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;
use Gloudemans\Shoppingcart\Exceptions\CartAlreadyStoredException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
        //$pedidos = Cart::all()->where('identifier', '=', '*'.$idUser);
        //dd($pedidos);
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
        //dd($pedido);
        //$lineasPedido = LineaPedido::all()->where('idPedido', "=", $pedido->id);

        if (auth()->user()->hasRole('profesor')) {
            return view("profesor.detallesPedido", ["pedido" => $pedido, "presupuesto" => $presupuesto, "idPedido" => $idPedido]);
        }

        if (auth()->user()->hasRole('admin')) {
            return view("admin.detallesPedido", ["pedido" => $pedido, "idPedido" => $idPedido, "profesor" => $profesor]);
        }


    }

    public function detallesPedidoAdmin($idPedido, $profesor)
    {
        $pedido = getCart($idPedido);
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();
        //dd($pedido);
        //$lineasPedido = LineaPedido::all()->where('idPedido', "=", $pedido->id);


        if (auth()->user()->hasRole('admin')) {
            return view("admin.detallesPedido", ["pedido" => $pedido, "idPedido" => $idPedido, "profesor" => $profesor]);
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

    /*
    $storedAll = DB::table('shoppingcart')->get();
    foreach ($storedAll as $carItem) {
        if (DB::connection()->getDriverName() === 'pgsql') {
            $cartObject = unserialize(base64_decode(data_get($carItem, 'content')));
            $allShopingCarts[$carItem->id] = [$cartObject, $carItem->identifier];
            //$allShopingCarts->put($carItem->id, $cartObject);
        } else {
            $cartObject = unserialize(data_get($carItem, 'content'));
            $allShopingCarts[$carItem->id] = [$cartObject, $carItem->identifier];
            //$allShopingCarts->put($carItem->id, $cartObject);
        }
    }*/

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

            $cartItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                'expectedDate' => $expectedDate,
                'expectedTime' => $expectedTime,
                'justification' => $justification,
                'fechaPedido' => $datePedido
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

        foreach ($itemsPedido as $ItemPedido) {
            $product = Producto::findOrFail($ItemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $ItemPedido->cantidad;

            $carItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                'expectedDate' => $expectedDate,
                'expectedTime' => $expectedTime,
                'justification' => $justification,
                'fechaPedido' => $datePedido
            ]);

            $carItem->setQuantity($quantity);
            $cartCollection->put($carItem->rowId, $carItem);
        }
        $allShopingCarts->put($pedido->id, $cartCollection);
    }


    /*
        $allShopingCarts = collect();
        $storedAll = DB::table('shoppingcart')->where('identifier', '=', $identifier)->get();
        foreach ($storedAll as $carItem) {
            if (DB::connection()->getDriverName() === 'pgsql') {
                $cartObject = unserialize(base64_decode(data_get($carItem, 'content')));
                dd($carItem);
                $allShopingCarts->put($carItem->id, $cartObject);
            } else {

                $cartObject = unserialize(data_get($carItem, 'content'));
                $allShopingCarts->put($carItem->id, $cartObject);
            }
        }
        //dd($allShopingCarts);*/

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
    //dd($pedido);

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

        $carItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
            'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
            'expectedDate' => $expectedDate,
            'expectedTime' => $expectedTime,
            'justification' => $justification,
            'fechaPedido' => $datePedido
        ]);

        $carItem->setQuantity($quantity);
        $allShopingCarts->put($carItem->rowId, $carItem);
    }
    /*$cartItem = DB::table('shoppingcart')->where('id', '=', $identifier)->first();
        if (DB::connection()->getDriverName() === 'pgsql') {
            $allShopingCarts = unserialize(base64_decode(data_get($cartItem, 'content')));
        } else {
            $allShopingCarts = unserialize(data_get($cartItem, 'content'));
        }
    //dd($allShopingCarts);*/
    return $allShopingCarts;
}


