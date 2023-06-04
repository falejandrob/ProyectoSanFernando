<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\LineaPedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Http\Controllers\generarCodigo;
use function App\Http\Controllers\obtenerCodigo;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $this->restoreOrder(Auth::id());
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);



        return $this->sendFailedLoginResponse($request);
    }

   /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        if (Cart::count() != 0){
            $this->store(Auth::id());
        }

        Auth::guard()->logout();


        $request->session()->regenerateToken();

        return redirect('/');
    }

    function store($identifier)
    {
        $pedido = new Pedido();

        $pedido->idUser = $identifier;
        $pedido->identificador = $this->generarCodigo();
        $pedido->fechaPedido = Carbon::now();
        $pedido->fechaPrevistaPedido = Carbon::parse(Cart::content()->first()->options->expectedDate . Cart::content()->first()->options->expectedTime);
        if (Cart::content()->first()->options->justification==null){
            $pedido->justificacion = "";
        }else{
            $pedido->justificacion = Cart::content()->first()->options->justification;
        }

        $pedido->estaPedido = false;
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
        Cart::destroy();
    }
    function restoreOrder($identifier)
    {
        $pedido = Pedido::where('idUser', $identifier)
            ->where('estaPedido', false)
            ->first();

        if ($pedido) {

            if (Cart::content()) {
                Cart::destroy();
            }

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

            $pedido->delete();
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

        $cod = $this->obtenerCodigo();

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
}
