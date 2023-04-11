<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosListar extends Component
{
    use WithPagination;

    protected $listeners = ['producto_update' =>'render'];

    public function render(){

        $productos = Producto::orderBy('id', 'desc')->paginate(10);
        $categorias = Categoria::all();
        return view('livewire.productos-listar', compact('productos'), compact('categorias'));
    }

    public function destroy($id){
        dd($id);
        Producto::destroy($id);
        $this->emit('producto_update');

    }
}
