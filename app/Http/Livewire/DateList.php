<?php

namespace App\Http\Livewire;

use App\Models\FechaMaximaPedido;
use App\Models\Proveedore;
use Livewire\Component;

class DateList extends Component
{
    protected $listeners = ['date_update' =>'render'];

    public function render()
    {
        $dates = FechaMaximaPedido::all();

        return view('livewire.date-list', ["dates" => $dates]);
    }

    public function destroyDate($id)
    {
        FechaMaximaPedido::find($id)->delete();
        session()->flash('success', 'El plazo se ha eliminado correctamente.');
    }
}
