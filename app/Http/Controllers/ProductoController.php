<?php

namespace App\Http\Controllers;


use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function aniadirProducto()
    {
        return view("producto.crear", ["categorias" => Categoria::all()]);
    }

    public function modificarProducto($id){
        return view("producto.modificar", ["producto" => Producto::find($id)], ["categorias" => Categoria::all()]);
    }

    public function listarProductos(){

        return view('producto.listar');
    }

    public function store(Request $request)
    {
        $foto = $request->file('foto')->get();
        $product = Producto::create([
            'nombre' => $request->nombre,
            'validado' => 1,
            'idCategoria' => $request->idCategoria,
            'foto' => $foto
        ]);

        $product->save();
        return redirect()->action([HomeController::class, 'index']);
    }

    public function update(Request $request, $id){
        $product = Producto::find($id);
        $product->update($request->all());
        return redirect()->action([ProductoController::class, 'listarProductos']);
    }

}
