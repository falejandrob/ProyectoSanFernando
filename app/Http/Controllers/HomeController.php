<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\User;
use App\Models\Proveedore;
use App\Models\ProductoProveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        if (auth()->user()->hasRole('profesor')) {
            return view('profesor.principal', ["presupuesto" => $presupuesto]);
        }

        if (auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')) {
            return view('admin.home');
        }
    }

    public function realizarPedido(){
        $fechaActual = Carbon::now();
        $closestDate = FechaMaximaPedido::closestToDate()->first();
        $expectedDate = date("Y-m-d");
        $expectedTime = date("H:i");

        $productos = Producto::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        return view("home", ["productos" => $productos, "presupuesto" => $presupuesto, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime, 'closestDate' => $closestDate, 'fechaActual' => $fechaActual]);
    }

    /**
     * Shows all the orders of a specific User
     *
     * @param $idUser
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function misPedidos($idUser)
    {
        $pedidos = getAllCarts(Auth::id());
        $collection = new Collection($pedidos);
        $perPage = 5;

        $pedidos = getAllCarts($idUser);

        $pedidos = $pedidos->sortByDesc(function ($pedido) {
            return strtotime($pedido->first()->options->fechaPedido);
        });

        $perPage = 6;
        $currentPage = request()->get('page', 1);

        $paginatedData = new LengthAwarePaginator(
            $pedidos->forPage($currentPage, $perPage),
            $pedidos->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        return view("profesor.misPedidos", ["pedidos" => $pedidos, "presupuesto" => $presupuesto]);
    }

    /**
     * Validate an order from a User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validarPedido($id,$nombre, $apellido,$email){
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 1;
        $pedido->save();

        Mail::send([], [], function($message) use ($nombre, $apellido,$email) {
            $message->to($email, $nombre.' '.$apellido)
                ->subject('Estado de su pedido')
                ->text('Hola buenas, Sr/Sra '.$nombre.' '.$apellido.', el estado de su pedido se ha actualizado. Un saludo');
        });


        session()->flash('success', 'El pedido se ha validado correctamente.');
        return redirect()->action([HomeController::class, 'totalPedidos']);
    }

    /**
     * Invalidate an order from a User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desvalidarPedido($id,$nombre, $apellido,$email){
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 2;
        $pedido->save();

        Mail::send([], [], function($message) use ($nombre, $apellido,$email) {
            $message->to($email, $nombre.' '.$apellido)
                ->subject('Estado de su pedido')
                ->text('Hola buenas, Sr/Sra '.$nombre.' '.$apellido.', el estado de su pedido se ha actualizado. Un saludo');
        });

        session()->flash('success', 'El pedido se ha invalidado correctamente.');
        return redirect()->action([HomeController::class, 'totalPedidos']);
    }

    /**
     * Show the details from a specific order
     *
     * @param $idPedido
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function detallesPedido($idPedido)
    {
        $pedido = getCart($idPedido);
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        if (auth()->user()->hasRole('profesor')) {
            return view("profesor.detallesPedido", ["pedido" => $pedido, "presupuesto" => $presupuesto, "idPedido" => $idPedido]);
        }

    }

    /**
     * Show the details from a specific order for an Admin User
     *
     * @param $idPedido
     * @param $profesor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function detallesPedidoAdmin($idPedido, $profesor)
    {
        $pedido = getCart($idPedido);
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        if (auth()->user()->hasRole('admin')) {
            return view("admin.detalles-pedido", ["pedido" => $pedido, "idPedido" => $idPedido, "profesor" => $profesor]);
        }
    }

    /**
     * Select a provider
     *
     * @param $idPedido
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function seleccionarProveedores($idPedido)
    {
        $productosConProveedor = ProductoProveedor::where('pedido', $idPedido)->get();
        $lineasPedido = LineaPedido::where('idPedido', $idPedido)->get();
        $proveedores = Proveedore::all();
        $categorias = Categoria::all();

        if (auth()->user()->hasRole('admin')) {
            return view("admin.seleccionarProveedores", ["lineasPedido" => $lineasPedido, "idPedido" => $idPedido, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
        }
    }

    /**
     * Delete a relation between provider and product of LineaPedido
     *
     * @param $idRelacion
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function quitarRelacion($idRelacion)
    {
        if(ProductoProveedor::find($idRelacion) != null) {
            $idPedido = ProductoProveedor::find($idRelacion)->pedido;

            ProductoProveedor::destroy($idRelacion);

            $productosConProveedor = ProductoProveedor::where('pedido', $idPedido)->get();
            $lineasPedido = LineaPedido::where('idPedido', $idPedido)->get();
            $proveedores = Proveedore::all();
            $categorias = Categoria::all();

            if (auth()->user()->hasRole('admin')) {
                session()->flash('success', 'La relacion se ha eliminado correctamente.');
                return view("admin.seleccionarProveedores", ["lineasPedido" => $lineasPedido, "idPedido" => $idPedido, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
            }
        } else {
            return redirect()->action([HomeController::class, 'totalPedidos']);
        }
    }

    /**
     * Set the provider of a specific product for LineaPedido
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function establecerProveedor(Request $request)
    {
        $productosSeleccionados = $request->input('productos');
        $proveedorSeleccionado = $request->input('proveedor');

        $lineasPedido = LineaPedido::where('idPedido', $request->id)->get();
        $proveedores = Proveedore::all();
        $categorias = Categoria::all();

        if($productosSeleccionados == null || $proveedorSeleccionado == null) {
            $productosConProveedor = ProductoProveedor::where('pedido', $request->id)->get();
            return view("admin.seleccionarProveedores", ["lineasPedido" => $lineasPedido, "idPedido" => $request->id, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
        }

        foreach ($productosSeleccionados as $item) {
            if(! $this->relacionExiste($request->id, $item)) {
                $nuevo = ProductoProveedor::create([
                    'pedido' => $request->id,
                    'lineaPedido' => $item,
                    'proveedor' => $proveedorSeleccionado,
                ]);

                $nuevo->save();
                session()->flash('success', 'El proveedor se ha guardado correctamente.');
            }
        }

        $productosConProveedor = ProductoProveedor::where('pedido', $request->id)->get();

        if (auth()->user()->hasRole('admin')) {
            return view("admin.seleccionarProveedores", ["lineasPedido" => $lineasPedido, "idPedido" => $request->id, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
        }
    }

    /**
     * Check if there is an existing relation between a provider and a product from LineaPedido
     *
     * @param $idPedido
     * @param $lineaPedido
     * @return bool
     */
    function relacionExiste($idPedido, $lineaPedido) {
        $productosConProveedor = ProductoProveedor::where('pedido', $idPedido)->get();

        foreach($productosConProveedor as $item) {
            if($item->pedido == $idPedido && $item->lineaPedido == $lineaPedido) {
                return true;
            }
        }

        return false;
    }

    /**
     * get the all the orders from all teachers
     *
     * @return view
     */

    public function totalPedidos()
    {
        $pedidos = getAllCartsTeachers();
        $pedidos = new Collection($pedidos);

        $pedidos = $pedidos->sortByDesc(function ($pedido) {
            $pedido = new Collection($pedido);
            $fechaEsperada = strtotime($pedido->first()->first()->options->expectedDate);
            $diferencia = abs(time() - $fechaEsperada);
            return $diferencia;
        })->reverse();


        $profesores = User::all();


        return view("admin.pedidos",["pedidos" => $pedidos, "profesores" => $profesores]);
    }

    public function addJustificacion(Request $request)
    {
        $justificacion = Session::get("justificacion");
        $justificacion = $justificacion . "\n" . $request->justificacion;
        Session::put("justificacion", $justificacion);


        return redirect()->action([HomeController::class, 'index']);
    }

    function downloadProvPdf($id){
        list($pdfName, $pdf) = $this->getPDFProv($id);

        return $pdf->stream($pdfName);
    }

    /**
     * get a pdf stream
     *
     * @param $id
     * @return mixed
     */
    function downloadPdf($id){

        list($pdfName, $pdf) = $this->getPDF($id);

        return $pdf->stream($pdfName);
    }

    /**
     * send a Mail with the pdf
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail($id)
    {
        list($pdfName, $pdf) = $this->getPDF($id);

        Mail::send('correo.pedido', [], function($message) use ($pdf, $pdfName){

            $message->to(Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos)
                ->subject('Su pedido Sr/Sra '.' '.Auth::user()->nombre.' '.Auth::user()->apellidos)
                ->attachData($pdf->output(), $pdfName);

        });

        session()->flash('success', 'El correo se ha enviado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }

    public function getPDFProv($id): array
    {
        $User = User::findOrFail(Pedido::findOrFail($id)->idUser);
        $lineasConProveedor = ProductoProveedor::where('pedido', $id)->get();
        $lineas = LineaPedido::all();

        $proveedores = Proveedore::all();
        $productos = getCart($id);
        $pdfNameP = 'Pedido_' .  auth()->user()->nombre . '-' . auth()->user()->apellidos . '.pdf';

        $dateTimeJustification = [
            'expectedDate' => $productos->first()->options->expectedDate,
            'expectedTime' => $productos->first()->options->expectedTime,
            'justification' => $productos->first()->options->justification,
        ];

        $pdfD = Pdf::loadView('pdf.productos-proveedores', compact('proveedores', 'productos', 'lineas', 'lineasConProveedor', 'dateTimeJustification', 'User'));
        return array($pdfNameP, $pdfD);
    }

    /**
     * Get the pdf view
     *
     * @param $id
     * @return array
     */
    public function getPDF($id): array
    {
        $User = User::findOrFail(Pedido::findOrFail($id)->idUser);
        $productos = getCart($id);
        $pdfName = 'Pedido_' . $productos->first()->options->expectedDate . '-' . $productos->first()->options->expectedTime . '_' . auth()->user()->nombre . '-' . auth()->user()->apellidos . '.pdf';

        $dateTimeJustification = [
            'expectedDate' => $productos->first()->options->expectedDate,
            'expectedTime' => $productos->first()->options->expectedTime,
            'justification' => $productos->first()->options->justification,
        ];

        $pdf = Pdf::loadView('pdf.productos', compact('productos', 'dateTimeJustification', 'User'));
        return array($pdfName, $pdf);
    }

}

/**
 *  Get all teacher cart from the databases
 *
 * @return array
 */
function getAllCartsTeachers()
{


    $allShopingCarts = [];
    $pedidos = Pedido::where('estaPedido', true)->get();

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
 * @return Collection
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
 * @return Collection
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


