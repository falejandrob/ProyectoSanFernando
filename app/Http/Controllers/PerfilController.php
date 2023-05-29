<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function perfil($idUser)
    {
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        $user = User::find($idUser);

        return view("profesor.perfil", ["presupuesto" => $presupuesto, "user" => $user]);
    }

    public function cambiarDatos(Request $request, $id){
        $profesor = User::find($id);

        $profesor->update($request->all());

        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();

        session()->flash('success', 'Los datos del profesor se ha modificado correctamente.');
        return view("profesor.perfil", ["presupuesto" => $presupuesto, "user" => $profesor]);
    }

    public function cambiarPass(Request $request, $id){
        $user1 = User::find($id);

        if (Hash::check($request->lastPassword, $user1->password)) {
            $user1->password = Hash::make($request->password);
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $length = 10;
            $token = substr(str_shuffle($pool),1,$length);
            $user1->remember_token = $token;
    
            $user1->save();
            $anio_actual = Carbon::now()->year;
            $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();
    
            session()->flash('success', 'La password del profesor se ha modificado correctamente.');
            return view("profesor.perfil", ["presupuesto" => $presupuesto, "user" => $user1]);
        } else {
            $anio_actual = Carbon::now()->year;
            $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();
            session()->flash('error', 'La contraseña actual no es la correcta.');
            return view("profesor.perfil", ["presupuesto" => $presupuesto, "user" => $user1]);
        }
    }
}
