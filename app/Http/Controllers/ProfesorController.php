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

    /**
     * Return the view to show all the Teachers
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listarProfesores() {
        return view('profesor.listar');
    }
    //

    /**
     * Return the modificarProfesor view
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * Modify an existing User
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(Request $request, $id){
        $profesor = User::find($id);


        if($request->rol == "admin") {
            $profesor->roles()->detach();
            $profesor->assignRole('admin');
        }

        if($request->rol == "profesor") {
            $profesor->roles()->detach();
            $profesor->assignRole('profesor');
        }

        $anio_actual = Carbon::now()->year;

        $this->updatePresupuesto($id, $anio_actual, $profesor, $request);

        $profesor->update($request->all());
        session()->flash('success', 'El profesor se ha modificado correctamente.');
        return redirect()->action([ProfesorController::class, 'listarProfesores']);
    }

    /**
     * Return the view to change to password to a User
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cambiarPassword($id) {
        return view("profesor.cambiarPassword", ["profesor" => User::find($id)]);
    }

    /**
     * Change the password to a User
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
     * Check if the teacher have a budget and update it, if not, set it
     *
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
            $presupuesto->idUser = $profesor->id;
            $presupuesto->anio = $anio_actual;
            $presupuesto->presupuestoTotal = $request->presupuesto;
        } else {
            $presupuesto->presupuestoTotal = $request->presupuesto;
        }

        $presupuesto->save();
    }
}
