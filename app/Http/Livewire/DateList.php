<?php

namespace App\Http\Livewire;

use App\Models\FechaMaximaPedido;
use App\Models\Producto;
use App\Models\Proveedore;
use Livewire\Component;
use Livewire\WithPagination;

class DateList extends Component
{

    use WithPagination;

    protected $listeners = ['date_update' =>'render'];

    public function render()
    {
        $datesPorPagina = 10;
        $maxPaginasMostradas = 3;

        $query = FechaMaximaPedido::where("id", ">=", 1)->orderBy('id', 'desc');

        $dates = $query->paginate($datesPorPagina);


        return view('livewire.date-list', compact('dates','maxPaginasMostradas'));
    }


    /**
     * Destroy a specific date
     *
     * @param $id
     * @return void
     */
    public function destroyDate($id)
    {
        FechaMaximaPedido::find($id)->delete();
        session()->flash('success', 'El plazo se ha eliminado correctamente.');
    }
}
