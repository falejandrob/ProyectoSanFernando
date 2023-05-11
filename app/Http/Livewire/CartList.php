<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartList extends Component
{
    //
    protected $listeners = ['cart_update' =>'render'];
    public $cart;
    public $rowId;
    public function render()
    {
        /*$fechaActual = Carbon::now();
        $hora = strtotime($fechaActual);
        $horaActual =  date("H:i", $hora);

        $fechaInicioPlazo = FechaMaximaPedido::selectRaw('fechaMinima')
            ->where('fechaMinima', '>=', $fechaActual)
            ->orderByRaw('fechaMinima ASC')
            ->limit(1)
            ->value('fechaMinima');

        $fechaMasProxima = FechaMaximaPedido::selectRaw('fechaMaxima')
            ->where('fechaMaxima', '>', $fechaActual)
            ->orderByRaw('fechaMaxima ASC')
            ->limit(1)
            ->value('fechaMaxima');

        $fechaMin = strtotime($fechaInicioPlazo);
        $fechaConFormatoMin = date('d-m-Y',$fechaMin);
        $fechaMinFormato = date('Y-m-d',$fechaMin);
        $horaConFormatoMin = date("H:i", $fechaMin);

        $fechaMax = strtotime($fechaMasProxima);
        $fechaMaxFormato = date('Y-m-d',$fechaMax);
        $fechaConFormatoMax = date('d-m-Y',$fechaMax);
        $horaConFormatoMax = date("H:i", $fechaMax);*/

        $closestDate = FechaMaximaPedido::closestToDate()->first();

        $expectedDate = date('Y-m-d');
        $expectedTime = date("H:i");

        $this->cart = Cart::content();
        $this->rowId = null;
        $categorias = Categoria::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        $fechaPedido = null;

        return view('livewire.cart-list', ['cart'=>$this->cart, 'categorias'=>$categorias, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime,
            "presupuesto" => $presupuesto, 'closestDate'=>$closestDate]);
    }

    public function removeFromCart($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        Cart::remove($this->rowId);
        $this->emit('product_listeners');
    }
    public function restElementToProduct($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty-1);
        $this->emit('product_listeners');
    }
    public function addElementToProduct($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty+1);
        $this->emit('product_listeners');
    }
    public function clearCart(){
        Cart::destroy();
        $this->emit('product_listeners');
    }
}
