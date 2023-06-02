<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\User;
use Livewire\Component;

class ProveedoresList extends Component
{
    protected $listeners = ['proveedor_update' =>'render'];

    public function render()
    {
        $proveedores = Proveedore::all();

        return view('livewire.proveedores-list', ["proveedores" => $proveedores]);
    }

    /**
     * Destroy a supplier from the database
     *
     * @param $id
     * @return void
     */
    public function destroyProveedor($id)
    {
        Proveedore::find($id)->delete();
        session()->flash('success', 'El proveedor se ha eliminado correctamente.');
    }
}
