<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;

class ProductsList extends Component
{
//
    public $product_id, $nombre, $validado, $idCategoria, $foto;

    protected $listeners = ['producto_update' =>'render'];

    public function render()
    {
        $productos = Producto::where("id", ">=", 1);
        if ($this->validado) {
            $productos->where('validado', $this->validado);
        }

        if ($this->idCategoria) {
            $productos->where('idCategoria', $this->idCategoria);
        }

        $productos =  $productos->paginate(10);
        $categorias = Categoria::all();
        return view('livewire.productos-listar', compact('productos', 'categorias'));
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
