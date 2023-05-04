<?php

namespace App\Http\Livewire;

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

    public function destroyProveedor($id)
    {
        Proveedore::destroy($id);
        $this->emit('proveedor_update');
        $this->emit('refresh');
    }
}
