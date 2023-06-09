<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $nombre, $validado, $idCategoria;
    public $productosPorPagina;
    public $categoryFilter;
    public $validateFilter;
    public $searchFilter;
    public $categorias;
    public $orden = 'asc';
    public $porPagina = 10;

    protected $listeners = ['producto_update' =>'render'];

    public function mount(){
        $this->categorias = Categoria::all();
    }

    public function updatingSearchFilter(){
        $this->resetPage();
    }

    public function render()
    {
        $maxPaginasMostradas = 3;
        $query = Producto::query()
            ->when($this->categoryFilter, function ($query) {
                $query->where('idCategoria', $this->categoryFilter);
            })
            ->when($this->validateFilter, function ($query) {
                $query->where('validado', $this->validateFilter);
            })
            ->when($this->searchFilter, function ($query) {
                $query->where('nombre', 'like', '%' . $this->searchFilter . '%');
            });

        $productos = $query->orderBy('nombre', $this->orden)->paginate($this->porPagina);

        return view('livewire.productos-listar', compact('productos','maxPaginasMostradas'));
    }

    public function ordenarAlfabeticamente()
    {
        $maxPaginasMostradas = 3;
        $query = Producto::query()
            ->when($this->categoryFilter, function ($query) {
                $query->where('idCategoria', $this->categoryFilter);
            })
            ->when($this->validateFilter, function ($query) {
                $query->where('validado', $this->validateFilter);
            })
            ->when($this->searchFilter, function ($query) {
                $query->where('nombre', 'like', '%' . $this->searchFilter . '%');
            });

        $this->orden = $this->orden === 'asc' ? 'desc' : 'asc';
        $productos = $query->orderBy('nombre', $this->orden)->paginate($this->porPagina);

        return view('livewire.productos-listar', compact('productos','maxPaginasMostradas'));
    }

    /**
     * Destroy product from database
     *
     * @param $id
     * @return void
     */
    public function destroyProduct($id)
    {
        Producto::find($id)->delete();
        session()->flash('success', 'El producto se ha eliminado correctamente.');
    }

    /**
     * Validate a product from database
     *
     * @param $id
     * @return void
     */
    public function validateProduct($id){
        $producto = Producto::findOrFail($id);
        $producto->validado = 0;
        $producto->save();
    }

    public function modifyProduct($id)
    {
        return redirect()->route('modificarProducto', ['id' => $id]);
    }
}
