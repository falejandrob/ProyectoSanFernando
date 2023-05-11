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
        if(auth()->user()->hasRole('admin')){
            $product = Producto::create([
                'nombre' => $request->nombre,
                'validado' => 0,
                'idCategoria' => $request->idCategoria,
            ]);

            $product->save();
            session()->flash('success', 'El producto se ha guardado correctamente.');
            return redirect()->action([ProductoController::class, 'aniadirProducto']);
        }
        if(auth()->user()->hasRole('profesor')){
            $product = Producto::create([
                'nombre' => $request->nombre,
                'validado' => 1,
                'idCategoria' => $request->idCategoria,
            ]);

            $product->save();
            return redirect()->action([HomeController::class, 'index']);
        }


    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->update($request->all());
        session()->flash('success', 'El producto se ha modificado correctamente.');
        return redirect()->action([ProductoController::class, 'listarProductos']);
    }
}
