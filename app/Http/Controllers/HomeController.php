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

        //dd(Auth::getSession());
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
    public function validarPedido($id, $nombre, $apellido, $email)
    {
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 1;
        $pedido->save();
        $orderIdentify = $pedido->identificador;

        Mail::send([], [], function ($message) use ($nombre, $apellido, $email, $orderIdentify) {

            $message->to($email, $nombre . ' ' . $apellido)
                ->subject('Actualización del estado de su pedido')
                ->html('<p>Estimado/a ' . $nombre . ' ' . $apellido . ',</p><p>Le informamos que el estado de su pedido con el identificador ' . $orderIdentify . ' ha sido actualizado. Nos complace confirmar que su pedido ha sido validado correctamente.</p><p>Si tiene alguna pregunta o inquietud, no dude en contactarnos.</p><p>Agradecemos su preferencia.</p>');

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
    public function desvalidarPedido($id, $nombre, $apellido, $email)
    {
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 2;
        $pedido->save();
        $orderIdentify = $pedido->identificador;

        Mail::send([], [], function ($message) use ($nombre, $apellido, $email, $orderIdentify) {

            $message->to($email, $nombre . ' ' . $apellido)
                ->subject('Actualización del estado de su pedido')
                ->html('<p>Estimado/a ' . $nombre . ' ' . $apellido . ',</p><p>Le informamos que el estado de su pedido con el identificador ' . $orderIdentify . ' ha sido actualizado. Lamentamos informarle que su pedido ha sido invalidado.</p><p>Si tiene alguna pregunta o inquietud, no dude en contactarnos.</p><p>Agradecemos su comprensión.</p>');

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

        if (auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')) {
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
        $colores = ["red", "blue", "green", "#E5D05B", "pink", "purple", "orange", "brown", "cyan", "magenta", "darkred", "darkblue", "#9E00DE", "#4DDE00", "#CCCF00", "darkcyan", "darkorange", "olive", "lightmagenta", "lightpurple", "black"];
        $categorias = [];

        foreach($lineasPedido as $linea) {
            if(!in_array(Producto::find($linea->idProducto)->idCategoria, $categorias)) {
                array_push($categorias, Producto::find($linea->idProducto)->idCategoria);
            }
        }

        if (auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')) {
            return view("admin.seleccionarProveedores", ["colores" => $colores, "lineasPedido" => $lineasPedido, "idPedido" => $idPedido, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
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
            $categorias = [];

            foreach($lineasPedido as $linea) {
                if(!in_array(Producto::find($linea->idProducto)->idCategoria, $categorias)) {
                    array_push($categorias, Producto::find($linea->idProducto)->idCategoria);
                }
            }

            $colores = ["red", "blue", "green", "#E5D05B", "pink", "purple", "orange", "brown", "cyan", "magenta", "darkred", "darkblue", "darkgreen", "#9E00DE", "#4DDE00", "#CCCF00", "darkorange", "olive", "lightmagenta", "lightpurple", "black"];

            if (auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')) {
                session()->flash('success', 'La relacion se ha eliminado correctamente.');
                return view("admin.seleccionarProveedores", ["colores" => $colores, "lineasPedido" => $lineasPedido, "idPedido" => $idPedido, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
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
        $categorias = [];

        foreach($lineasPedido as $linea) {
            if(!in_array(Producto::find($linea->idProducto)->idCategoria, $categorias)) {
                array_push($categorias, Producto::find($linea->idProducto)->idCategoria);
            }
        }
        
        $colores = ["red", "blue", "green", "#E5D05B", "pink", "purple", "orange", "brown", "cyan", "magenta", "darkred", "darkblue", "darkgreen", "#9E00DE", "#4DDE00", "#CCCF00", "darkorange", "olive", "lightmagenta", "lightpurple", "black"];

        if($productosSeleccionados == null || $proveedorSeleccionado == null) {
            $productosConProveedor = ProductoProveedor::where('pedido', $request->id)->get();
            return view("admin.seleccionarProveedores", ["colores" => $colores, "lineasPedido" => $lineasPedido, "idPedido" => $request->id, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
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

        if (auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')) {
            return view("admin.seleccionarProveedores", ["colores" => $colores, "lineasPedido" => $lineasPedido, "idPedido" => $request->id, "proveedores" => $proveedores, "categorias" => $categorias, "productosConProveedor" => $productosConProveedor]);
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

    public function papeleraPedidos()
    {
        $pedidos = Pedido::where('eliminado', '1')->get();
        $profesores = User::all();

        return view("admin.papeleraPedidos",["pedidos" => $pedidos, "profesores" => $profesores]);
    }

    public function restaurarPedido($idPedido)
    {
        $pedido = Pedido::find($idPedido);
        $pedido->eliminado = '0';
        $pedido->save();

        /*$pedidos = Pedido::where('eliminado', '1')->get();*/

        $pedidos = getAllCartsTeachers();
        $pedidos = new Collection($pedidos);

        $pedidos = $pedidos->sortByDesc(function ($pedido) {
            $pedido = new Collection($pedido);
            $fechaEsperada = strtotime($pedido->first()->first()->options->expectedDate);
            $diferencia = abs(time() - $fechaEsperada);
            return $diferencia;
        })->reverse();

        $profesores = User::all();

        session()->flash('success', 'El pedido se ha restaurado correctamente.');
        return view("admin.pedidos",["pedidos" => $pedidos, "profesores" => $profesores]);
    }

    public function papeleraPedidosProfesor($idProfesor)
    {
        $pedidos = Pedido::where('eliminado', '1')
            ->where('idUser', $idProfesor)
            ->get();

        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', $idProfesor)->where('anio', $anio_actual)->first();

        return view("profesor.papeleraPedidos",["pedidos" => $pedidos, "presupuesto" => $presupuesto]);
    }

    public function restaurarPedidoProfesor($idPedido)
    {
        $pedido = Pedido::find($idPedido);
        $idProfesor = $pedido->idUser;
        $pedido->eliminado = '0';
        $pedido->save();

        /*$pedidos = Pedido::where('eliminado', '1')
            ->where('idUser', $idProfesor)
            ->get();*/

        $pedidos = getAllCarts(Auth::id());

        $pedidos = $pedidos->sortByDesc(function ($pedido) {
            return strtotime($pedido->first()->options->fechaPedido);
        });

        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', $idProfesor)->where('anio', $anio_actual)->first();

        session()->flash('success', 'El pedido se ha restaurado correctamente.');
        return view("profesor.misPedidos",["pedidos" => $pedidos, "presupuesto" => $presupuesto]);
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
        $user = User::findOrFail(Pedido::findOrFail($id)->idUser);
        $lineasConProveedor = ProductoProveedor::where('pedido', $id)->get();
        $lineas = LineaPedido::all();
        $proveedores = Proveedore::all();
        $productos = getCart($id);
        $pdfNameP = $productos->first()->options->get('identificador'). '.pdf';;
        $fechaConFormato = \Carbon\Carbon::parse($productos->first()->options->expectedDate)->format('d/m/Y');
        $horaConFormato = \Carbon\Carbon::parse($productos->first()->options->expectedTime)->format('H:i');
        $dompdf = new Dompdf();

        $dateTimeJustification = [
            'expectedDate' => $fechaConFormato,
            'expectedTime' => $horaConFormato,
            'justification' => $productos->first()->options->justification,
        ];

        $proveedoresMap = [];
        foreach ($proveedores as $proveedor) {
            $proveedoresMap[$proveedor->id] = ['nombre' => $proveedor->nombre, 'productos' => []];
        }

        $categoryOrder = ['Vegetales', 'Carne y Embutidos', 'Pescados y mariscos', 'Varios'];
        $categoryMap = [];
        foreach ($productos as $producto) {
            $categoria = $producto->options->categoria;

            if ($categoria === 'Hortalizas' || $categoria === 'Frutas, Frutos Secos') {
                $categoria = 'Vegetales';
            } elseif ($categoria === 'Carnes, Aves, Embutidos') {
                $categoria = 'Carne y Embutidos';
            } elseif ($categoria === 'Pescados, Mariscos') {
                $categoria = 'Pescados y mariscos';
            } else {
                $categoria = 'Varios';
            }

            if (!isset($categoryMap[$categoria])) {
                $categoryMap[$categoria] = [];
            }

            $lineaProv = $lineasConProveedor->first(function ($lineaProv) use ($lineas, $producto) {
                return $lineas->first(function ($linea) use ($lineaProv, $producto) {
                        return $lineaProv->lineaPedido == $linea->id && $linea->idProducto == $producto->id;
                    }) !== null;
            });

            if ($lineaProv) {
                $producto->options->proveedor = $proveedoresMap[$lineaProv->proveedor]['nombre'];
                $proveedoresMap[$lineaProv->proveedor]['productos'][] = $producto;
            }

            $categoryMap[$categoria][] = $producto;
        }

        $pdfD = Pdf::loadView('pdf.productos-proveedores', compact('categoryOrder', 'categoryMap', 'proveedoresMap', 'dateTimeJustification', 'user', 'dompdf'));

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
        $user = User::findOrFail(Pedido::findOrFail($id)->idUser);
        $productos = getCart($id);
        $pdfName = $productos->first()->options->get('identificador'). '.pdf';
        $fechaConFormato = \Carbon\Carbon::parse($productos->first()->options->expectedDate)->format('d/m/Y');
        $horaConFormato = \Carbon\Carbon::parse($productos->first()->options->expectedTime)->format('H:i');

        $dateTimeJustification = [
            'expectedDate' => $fechaConFormato,
            'expectedTime' => $horaConFormato,
            'justification' => $productos->first()->options->justification,
        ];

        $categorias = ['Hortalizas' => 'Vegetales', 'Frutas, Frutos Secos' => 'Vegetales',
            'Carnes, Aves, Embutidos' => 'Carne y Embutidos',
            'Pescados, Mariscos' => 'Pescados y mariscos'];

        $categoryOrder = ['Vegetales', 'Carne y Embutidos', 'Pescados y mariscos', 'Varios'];
        $categoryMap = array_fill_keys($categoryOrder, []);

        foreach($productos as $producto) {
            $categoria = $producto->options->categoria;
            $categoria = $categorias[$categoria] ?? 'Varios';
            $categoryMap[$categoria][] = $producto;
        }

        $pdf = Pdf::loadView('pdf.productos', compact('productos', 'dateTimeJustification', 'user','categoryMap', 'categoryOrder'));
        return array($pdfName, $pdf);
    }

    public function autores(){
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();
        return view('autores', ['presupuesto'=>$presupuesto]);
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
        $identificador = $pedido->identificador;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $itemPedido) {
            $product = Producto::findOrFail($itemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $itemPedido->cantidad;
            $observacion = $itemPedido->observaciones;

            $cartItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'identificador' => $identificador,
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
        $identificador = $pedido->identificador;

        $itemsPedido = LineaPedido::where('idPedido', $idPedido)->get();

        foreach ($itemsPedido as $itemPedido) {
            $product = Producto::findOrFail($itemPedido->idProducto);
            $productId = $product->id;
            $productName = $product->nombre;
            $quantity = $itemPedido->cantidad;
            $observacion = $itemPedido->observaciones;

            $carItem = CartItem::fromAttributes($productId, $productName, 0.0, 0.0, [
                'categoria' => Categoria::findOrFail($product->idCategoria)->nombre,
                'identificador' => $identificador,
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
    $identificador = $pedido->identificador;

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
            'identificador' => $identificador,
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


