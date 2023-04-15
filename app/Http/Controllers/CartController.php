<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class CartController extends Controller
{
    //
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

    public function confirm(){
        $productos = Cart::content();
        $pdf = Pdf::loadView('pdf.productos', compact('productos'));
        Pdf::setOption('isRemoteEnabled', TRUE);
        //Cart::destroy();
        return $pdf->download('invoice.pdf');
    }

}
