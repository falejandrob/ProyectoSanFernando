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
        //
        $fechaActual = Carbon::now();
        $closestDate = FechaMaximaPedido::closestToDate()->first();

        /*$hora = strtotime($fechaActual);
        $horaActual =  date("H:i", $hora);

        $fechaMasProxima = FechaMaximaPedido::selectRaw('fechaMaxima')
            ->where('fechaMaxima', '>', $fechaActual)
            ->orderByRaw('fechaMaxima ASC')
            ->limit(1)
            ->value('fechaMaxima');

        $fechaPasada = FechaMaximaPedido::selectRaw('fechaMaxima')
            ->where('fechaMaxima', '<', $fechaActual)
            ->orderByRaw('fechaMaxima ASC')
            ->limit(1)
            ->value('fechaMaxima');



        dd($closestDate);
        dd($fechaPasada);
       $fecha = strtotime($fechaPasada->fechaMaxima);
        $fechaConFormato = date('d-m-Y',$fecha);
        $horaConFormato = date("H:i", $fecha);*/




        $this->searchTerm = preg_replace('/[^a-zA-Z0-9]/', '', $this->searchTerm);
        if(empty($this->searchTerm)) {
            //$this->productos = Producto::where('validado', '=','3')->skip(50)->take(50)->get();
            //$this->productos = Producto::all()->skip(50)->take(50);
            $this->productos = Producto::where('validado', '=','3')->get();
            $alerta = false;
        } else {
            $this->productos = Producto::where('nombre', 'like', '%'.$this->searchTerm.'%')->get();
            $alerta = true;
        }

        $this->categorias = Categoria::all();
        $this->cart = Cart::content();
        //dd($this->cart);
        return view('livewire.productos-buscar', ["categorias" => $this->categorias, "carrito"=>$this->cart, 'alerta'=>$alerta, 'fechaActual' => $fechaActual, 'closestDate'=>$closestDate]);
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
