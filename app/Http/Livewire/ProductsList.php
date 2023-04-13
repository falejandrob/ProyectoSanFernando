<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;

class ProductsList extends Component
{

    private $productos;
    private $categorias;

    public $product_id, $nombre, $validado, $idCategoria, $foto;

    protected $listeners = ['producto_update' =>'render'];

    public function render()
    {
        $this->productos = Producto::orderBy('id', 'desc')->paginate(10);
        $this->categorias = Categoria::all();
        return view('livewire.productos-listar', ["categorias" => $this->categorias],["productos" => $this->productos]);
    }

    public function destroyProduct($id)
    {
        Producto::destroy($id);
        $this->emit('producto_update');
        $this->emit('refresh');
    }

    public function validateProduct($id){
        $producto = Producto::findOrFail($id);
        $producto->validado = 0;
        $producto->save();
    }
}
