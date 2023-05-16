<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfesorController extends Controller
{
    public function listarProfesores() {
        return view('profesor.listar');
    }
    //

    public function modificarProfesor($id){
        $profesor = User::find($id);
        $anio_actual = Carbon::now()->year;
        $presupuesto = 0;

        try {
            $presupuesto = Presupuesto::where('idUser', $profesor->id)->where('anio', $anio_actual)->first()->presupuestoTotal;
        } catch (\Exception $e) {

        }

        return view("profesor.modificar", ["profesor" => $profesor, "presupuesto" => $presupuesto]);
    }

    public function update(Request $request, $id){
        $profesor = User::find($id);

        if($request->file('foto') != null) {
            $request->foto = $request->file('foto')->get();
        } else {
            $request->foto = null;
        }

        if($request->rol == "admin") {
            $profesor->roles()->detach();
            $profesor->assignRole('admin');
        }

        if($request->rol == "profesor") {
            $profesor->roles()->detach();
            $profesor->assignRole('profesor');
        }

        $anio_actual = Carbon::now()->year;

<<<<<<< HEAD
        $presupuesto = Presupuesto::all()->where("idUser", "=", $id)
            ->where("anio", "=", $anio_actual)->first();

        if($presupuesto != null) {
            $presupuesto->presupuestoTotal = $request->presupuesto;
            $presupuesto->save();
        } else {
            $presupuesto = Presupuesto::create([
                'idUser' => $id,
                'anio' => $anio_actual,
                'presupuestoTotal' => $request->presupuesto
            ]);
            $presupuesto->save();
        }
=======
        $this->updatePresupuesto($id, $anio_actual, $profesor, $request);
>>>>>>> 9b9f6ccd43b84f34ef25848e426d37707533f17a

        $profesor->update($request->all());
        session()->flash('success', 'El profesor se ha modificado correctamente.');
        return redirect()->action([ProfesorController::class, 'listarProfesores']);
    }

    public function cambiarPassword($id) {
        return view("profesor.cambiarPassword", ["profesor" => User::find($id)]);
    }

    public function pass(Request $request, $id){
        $user1 = User::find($id);
        $user1->password = Hash::make($request->password);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 10;
        $token = substr(str_shuffle($pool),1,$length);
        $user1->remember_token = $token;

        $user1->save();
        return redirect()->action([ProfesorController::class, 'listarProfesores']);
    }

    /**
     * @param $id
     * @param int $anio_actual
     * @param $profesor
     * @param Request $request
     * @return void
     */
    public function updatePresupuesto($id, int $anio_actual, $profesor, Request $request): void
    {
        $presupuesto = Presupuesto::all()->where("idUser", "=", $id)
            ->where("anio", "=", $anio_actual)->first();

        if ($presupuesto == null) {
            $presupuesto = new Presupuesto();
            //dd($request);
            $presupuesto->idUser = $profesor->id;
            $presupuesto->anio = $anio_actual;
            $presupuesto->presupuestoTotal = $request->presupuesto;
        } else {
            $presupuesto->presupuestoTotal = $request->presupuesto;
        }

        $presupuesto->save();
    }
}
