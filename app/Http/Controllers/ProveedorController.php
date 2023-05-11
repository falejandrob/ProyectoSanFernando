<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    public function store(Request $request)
    {
        $proveedor = Proveedore::create([
            'nombre' => $request->nombre,
        ]);

        $proveedor->save();
        session()->flash('success', 'El proveedor se ha guardado correctamente.');
        return redirect()->action([ProveedorController::class, 'aniadirProveedor']);
    }

    public function aniadirProveedor()
    {
        return view("proveedor.aniadir");
    }


    public function listarProveedores()
    {
        return view('proveedor.listar');
    }

    //

    public function modificarProveedor($id)
    {
        return view("proveedor.modificar", ["proveedor" => Proveedore::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedore::find($id);

        $proveedor->update($request->all());
        session()->flash('success', 'El proveedor se ha modificado correctamente.');
        return redirect()->action([ProveedorController::class, 'listarProveedores']);
    }
}
