<?php

namespace App\Http\Controllers;


use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
//
    public function aniadirProducto()
    {
        return view("producto.crear", ["categorias" => Categoria::all()]);
    }

    public function modificarProducto($id)
    {
        return view("producto.modificar", ["producto" => Producto::find($id)], ["categorias" => Categoria::all()]);
    }

    public function listarProductos()
    {

        return view('producto.listar');
    }

    public function store(Request $request)
    {
        if ($request->file('foto') != null) {
            $foto = $request->file('foto')->get();
        } else {
            $foto = null;
        }

        if(auth()->user()->hasRole('admin')){
            $product = Producto::create([
                'nombre' => $request->nombre,
                'validado' => 0,
                'idCategoria' => $request->idCategoria,

            ]);
        }
        if(auth()->user()->hasRole('profesor')){
            $product = Producto::create([
                'nombre' => $request->nombre,
                'validado' => 1,
                'idCategoria' => $request->idCategoria,

            ]);
        }



        $product->save();
        return redirect()->action([ProductoController::class, 'listarProductos']);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->update($request->all());
        return redirect()->action([ProductoController::class, 'listarProductos']);


    }
}
