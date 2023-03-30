<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;

class ProductosBuscar extends Component
{
    public $searchTerm = '';
    public $productos;
    public $categorias;

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
}
