<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\User;
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

        return view("profesor.misPedidos", ["paginatedData" => $paginatedData, "presupuesto" => $presupuesto]);
    }

    public function validarPedido($id){
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 1;
        $pedido->save();

        session()->flash('success', 'El pedido se ha validado correctamente.');
        return view('admin.pedidos', compact('pedidos', 'profesores'));
    }

    public function desvalidarPedido($id){
        $pedidos = getAllCartsTeachers();
        $profesores = User::all();

        $pedido = Pedido::findOrFail($id);
        $pedido->validado = 0;
        $pedido->save();

        session()->flash('success', 'El pedido se ha desvalidado correctamente.');
        return view('admin.pedidos', compact('pedidos', 'profesores'));
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
        $pedidos = new Collection($pedidos);

        $pedidos = $pedidos->sortByDesc(function ($pedido) {
            $pedido = new Collection($pedido);
            $fechaEsperada = strtotime($pedido->first()->first()->options->expectedDate);
            $diferencia = abs(time() - $fechaEsperada);
            return $diferencia;
        })->reverse();

        /*$perPage = 1;
        $currentPage = request()->get('page', 1);

        $paginatedData = new LengthAwarePaginator(
            $pedidos->forPage($currentPage, $perPage),
            $pedidos->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );*/

        $totalItems = $pedidos->total(); // Número total de elementos paginados
        $perPage = $pedidos->perPage(); // Número de elementos por página

        $pagesToShow = 2;

        $onEachSide = floor(($pagesToShow - 1) / 2);

        $currentPage = $data->currentPage();

        $from = max(1, $currentPage - $onEachSide);
        $to = min($currentPage + $onEachSide, $data->lastPage());

        $paginator = new LengthAwarePaginator(
            $pedidos->items(), // Elementos de la página actual
            $totalItems, // Total de elementos
            $perPage, // Número de elementos por página
            $currentPage, // Página actual
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(), // URL base
                'pageName' => 'page', // Nombre del parámetro de página en la URL
            ]
        );

        $paginator->setPageName('page')->setLastPage($data->lastPage())
            ->setPath(LengthAwarePaginator::resolveCurrentPath())
            ->appends(request()->except('page'))
            ->setPageRange($from, $to);


        $profesores = User::all();


        return view("admin.pedidos", compact('paginatedData', 'profesores'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addJustificacion(Request $request)
    {
        $justificacion = Session::get("justificacion");
        $justificacion = $justificacion . "\n" . $request->justificacion;
        Session::put("justificacion", $justificacion);


        return redirect()->action([HomeController::class, 'index']);
    }

    /**
     * @param $id
     * @return mixed
     */
    function downloadPdf($id){

        list($pdfName, $pdf) = $this->getPDF($id);

        return $pdf->stream($pdfName);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMail($id)
    {
        list($pdfName, $pdf) = $this->getPDF($id);

        Mail::send('correo.enviar', [], function($message) use ($pdf, $pdfName){

            $message->to(Auth::user()->email, Auth::user()->nombre.' '.Auth::user()->apellidos)
                ->subject('Send mail from laravel')
                ->attachData($pdf->output(), $pdfName);

        });

        session()->flash('success', 'El correo se ha enviado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }

    /**
     * @param $id
     * @return array
     */
    public function getPDF($id): array
    {
        $User = User::findOrFail(Pedido::findOrFail($id)->idUser);
        dd($User);
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
 *
 * @return array
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


