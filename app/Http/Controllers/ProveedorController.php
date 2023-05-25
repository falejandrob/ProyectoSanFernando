<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    /**
     * Store a new Provider
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $proveedor = Proveedore::create([
            'nombre' => $request->nombre,
        ]);

        $proveedor->save();
        session()->flash('success', 'El proveedor se ha guardado correctamente.');
        return redirect()->action([ProveedorController::class, 'aniadirProveedor']);
    }

    /**
     * Return the view to add a new provider
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function aniadirProveedor()
    {
        return view("proveedor.aniadir");
    }


    /**
     * Return the view to show the providers
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listarProveedores()
    {
        return view('proveedor.listar');
    }

    /**
     * Return the view to update the providers
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function modificarProveedor($id)
    {
        return view("proveedor.modificar", ["proveedor" => Proveedore::find($id)]);
    }

    /**
     * Update the providers
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedore::find($id);

        $proveedor->update($request->all());
        session()->flash('success', 'El proveedor se ha modificado correctamente.');
        return redirect()->action([ProveedorController::class, 'listarProveedores']);
    }
}
