<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CarritoController;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\Producto;
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
        //
        if(empty($this->searchTerm)) {
            $this->productos = Producto::all();
        } else {
            $this->productos = Producto::where('nombre', 'like', '%'.$this->searchTerm.'%')->get();
        }

        $this->categorias = Categoria::all();
        $this->cart = Cart::content();
        //dd($this->cart);
        return view('livewire.productos-buscar', ["categorias" => $this->categorias, "carrito"=>$this->cart]);
    }


    public function addToCart($product_id){
        $producto = Producto::findOrFail($product_id);
        //dd($producto);
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

    public function mount(){
        $this->productos = Producto::all();
        foreach ($this->productos as $producto){
            $this->cantidad[$producto->id] = 1;
        }
    }

    public function removeFromCart($rowId){
        //@dd($productoCarrito);
        Cart::remove($rowId);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }
    public function restElementToProduct($rowId){
        Cart::update($rowId, Cart::get($rowId)->qty-1);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }
    public function addElementToProduct($rowId){
        Cart::update($rowId, Cart::get($rowId)->qty+1);
        $this->emit('product_listeners');
        $this->emit('cart_update');
    }
}
