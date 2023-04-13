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

    public function edit($id){
        $product = Producto::find($id);
        $this->product_id = $product->id;
        $this->nombre = $product->nombre;
        $this->validado = $product->validado;
        $this->idCategoria = $product->idCatgeroia;
        $this->foto = $product->foto;
        return view('livewire.update-product', ["product" => $product->id], ["categorias" => $this->categorias]);
    }

    public function update(){
        $this->validate([
            'nombre' => 'required',
            'idCategoria' => 'required',
            'foto' => 'required'

        ]);
        $product = Producto::find($this->product_id);
        $product->update([
            'nombre'        => $this->nombre,
            'idCategoria' => $this->idCategoria,
            'validado'    => $this->validado,
            'foto'       => $this->foto
        ]);
        $this->reset();
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
