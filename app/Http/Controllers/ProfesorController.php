<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesorController extends Controller
{
    public function listarProfesores() {
        return view('profesor.listar');
    }
    //

    public function modificarProfesor($id){
        return view("profesor.modificar", ["profesor" => User::find($id)]);
    }

    public function update(Request $request, $id){
        $product = User::find($id);

        if($request->file('foto') != null) {
            $request->foto = $request->file('foto')->get();
        } else {
            $request->foto = null;
        }

        $product->update($request->all());
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
}
