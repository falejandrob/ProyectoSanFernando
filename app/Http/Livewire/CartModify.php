<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartModify extends Component
{
    protected $listeners = ['cart_update' => 'render'];
    public $cart;
    public $rowId;

    public function render()
    {
        $closestDate = FechaMaximaPedido::closestToDate()->first();

        $expectedDate = date('Y-m-d');
        $expectedTime = date("H:i");

        $this->cart = Cart::content();
        $this->rowId = null;
        $categorias = Categoria::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();
        if ($presupuesto != null) {
            $presupuestoTotal = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->get();
            $total = $presupuestoTotal[0]->getAttribute('presupuestoTotal');
            return view('livewire.cart-modify', ['cart' => $this->cart, 'categorias' => $categorias, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime,
                "presupuesto" => $presupuesto, 'closestDate' => $closestDate, 'total' => $total]);
        }
        
        return view('livewire.cart-modify', ['cart' => $this->cart, 'categorias' => $categorias, "expectedDate" => $expectedDate, "expectedTime" => $expectedTime,
            "presupuesto" => $presupuesto, 'closestDate' => $closestDate]);
    }

    /**
     * Remove element from the cart session
     *
     * @param $productoCarritoJson
     * @return void
     */
    public function removeFromCart($productoCarritoJson)
    {
        $productoCarrito = json_decode($productoCarritoJson);
        $this->rowId = $productoCarrito->rowId;
        Cart::remove($this->rowId);
        $this->emit('product_listeners');
    }

    /**
     * Rest one number to the element from the cart session
     *
     * @param $productoCarritoJson
     * @return void
     */
    public function restElementToProduct($productoCarritoJson)
    {
        $productoCarrito = json_decode($productoCarritoJson);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty - 1);
        $this->emit('product_listeners');
    }

    /**
     * Plus one number to the element from the cart session
     *
     * @param $productoCarritoJson
     * @return void
     */
    public function addElementToProduct($productoCarritoJson)
    {
        $productoCarrito = json_decode($productoCarritoJson);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty + 1);
        $this->emit('product_listeners');
    }

    /**
     * Remove all elements from the cart session
     *
     * @return void
     */

    public function clearCart()
    {
        Cart::destroy();
        $this->emit('product_listeners');
    }
}
