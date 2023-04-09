<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ProductosBuscar extends Component
{
    public $searchTerm = '';
    public $productos;
    public $categorias;
    public array $cantidad = [];
    protected $listeners = ['product_listeners'=>'render'];

    public function render()
    {
        if(empty($this->searchTerm)) {
            $this->productos = Producto::all();
        } else {
            $this->productos = Producto::where('nombre', 'like', '%'.$this->searchTerm.'%')->get();
        }

        $this->categorias = Categoria::all();

        return view('livewire.productos-buscar', ["categorias" => $this->categorias]);
    }


    public function addToCart($product_id){
        $producto = Producto::findOrFail($product_id);
        Cart::add(
            $producto->id,
            $producto->nombre,
            $this->cantidad[$product_id],
            0.00,
        );
        $this->emit('cart_update');
    }

    public function mount(){
        $this->productos = Producto::all();
        foreach ($this->productos as $producto){
            $this->cantidad[$producto->id] = 1;
        }
    }
}
