<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ProfesoresList extends Component
{//
    protected $listeners = ['profesor_update' =>'render'];

    public function render()
    {
        $profesores = DB::table('users')->paginate(10);

        return view('livewire.profesores-list', ["profesores" => $profesores]);
    }

    public function destroyProfesor($id)
    {
        User::destroy($id);
        $this->emit('profesor_update');
        $this->emit('refresh');
    }
}
