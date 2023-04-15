<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(Request $request)
    {
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

    public function remove(Request $request)
    {
        /* Cart::remove($request->rowId);
         return redirect()->route('home')->with('message','Eliminado correctamente');*/
    }

    public function confirm(Request $request)
    {
        $dateTimeJustification =[
            'expectedDate' => Carbon::parse($request->expectedDate)->format('d/m/Y'),
            'expectedTime'=>$request->expectedTime,
            'justification'=>$request->justification,
        ];
        $productos = Cart::content();
        $pdf = Pdf::loadView('pdf.productos', compact('productos', 'dateTimeJustification'));
        Pdf::setOption('isRemoteEnabled', TRUE);
        Cart::destroy();
        $pdf->download('invoice.pdf');
        return $pdf->stream();
    }


}
