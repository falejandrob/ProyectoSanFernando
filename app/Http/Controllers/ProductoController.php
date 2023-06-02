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

    /**
     * Return view to add a new product
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function aniadirProducto()
    {
        return view("producto.crear", ["categorias" => Categoria::all()]);
    }

    /**
     * Return view to modify a product
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function modificarProducto($id)
    {
        return view("producto.modificar", ["producto" => Producto::find($id)], ["categorias" => Categoria::all()]);
    }

    /**
     * Show all the products
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listarProductos()
    {

        return view('producto.listar');
    }

    /**
     * Store a new product validated if it's an admin who insert and invalidated if not
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('gestor')){
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

    /**
     * Update a product
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->update($request->all());
        session()->flash('success', 'El producto se ha modificado correctamente.');
        return redirect()->action([ProductoController::class, 'listarProductos']);
    }
}
