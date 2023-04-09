<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store (Request $request){
       /* dd($request->cantidad);
        $producto = Producto::findOrFail($request->input('producto_id'));
        Cart::add(
            $producto->id,
            $producto->nombre,
            $request->cantidad,
            0.00,
        );
        return redirect()->route('home')->with('message','Añadido correctamente');*/

    }
    public function remove (Request $request){
       /* Cart::remove($request->rowId);
        return redirect()->route('home')->with('message','Eliminado correctamente');*/
    }
}
