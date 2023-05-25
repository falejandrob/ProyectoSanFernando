<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CarritoController;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\Producto;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosBuscar extends Component
{

    public $searchTerm = '';
    public $productos;
    public $categorias;
    public $cart;
    public array $cantidad = [];
    protected $listeners = ['product_listeners'=>'render'];

    public function render()
    {

        $fechaActual = Carbon::now();
        $closestDate = FechaMaximaPedido::closestToDate()->first();

        $this->searchTerm = preg_replace('/[^a-zA-Z0-9 ]/', '', $this->searchTerm);
        if (strlen($this->searchTerm) >= 3){
            if(empty($this->searchTerm)) {
                $this->productos = Producto::where('validado', '=','3')->get();
                $alerta = false;
            } else {
                $this->productos = Producto::where('nombre', 'like', '%'.$this->searchTerm.'%')->get();
                $alerta = true;
            }
        }else{
            $this->productos = collect();
            $alerta = false;
        }


        $this->categorias = Categoria::all();
        $this->cart = Cart::content();
        return view('livewire.productos-buscar', ["categorias" => $this->categorias, "carrito"=>$this->cart, 'alerta'=>$alerta, 'fechaActual' => $fechaActual, 'closestDate'=>$closestDate]);
    }


    /**
     * We add to the session cart a element
     *
     * @param $product_id
     * @return void
     */
    public function addToCart($product_id){
        $producto = Producto::findOrFail($product_id);
        Cart::add([
            'id'=>$producto->id,
            'name'=>$producto->nombre,
            'qty'=>$this->cantidad[$product_id],
            'price'=>0.00,
            'weight'=>0.00,
            'options'=>[
                'categoria'=>Categoria::findOrFail($producto->idCategoria)->nombre,
            ]

        ]);



        $this->emit('cart_update');
    }


    /**
     * Remove element from the cart session
     *
     * @param $rowId
     * @return void
     */
    public function removeFromCart($rowId){
        Cart::remove($rowId);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }

    /**
     * Rest one number to the element from the cart session
     *
     * @param $rowId
     * @return void
     */
    public function restElementToProduct($rowId){
        Cart::update($rowId, Cart::get($rowId)->qty-1);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }

    /**
     * Plus one number to the element from the cart session
     *
     * @param $rowId
     * @return void
     */
    public function addElementToProduct($rowId){
        Cart::update($rowId, Cart::get($rowId)->qty+1);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }
}
