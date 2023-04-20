<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\ItemCarrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Agrega un elemento al carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregarElemento(Request $request)
    {
        // Verifica si el usuario ha iniciado sesión
        if (Auth::check()) {
            $usuarioId = Auth::id();

            // Busca el carrito del usuario
            $carrito = Carrito::where('user_id', $usuarioId)->first();

            // Si el carrito no existe, crea uno nuevo y agrega el elemento al ItemCarrito
            if (!$carrito || $carrito->estado !== 'activo') {
                $carrito = new Carrito([
                    'user_id' => $usuarioId,
                    'num_elementos' => 0,
                    'estado' => 'activo',
                ]);
                $carrito->save();

                $itemCarrito = new ItemCarrito([
                    'producto_id' => $request->producto_id,
                    'carrito_id' => $carrito->id,
                    'cantidad' => 1,
                    'precio' => $request->precio,
                ]);
                $itemCarrito->save();

                $carrito->num_elementos = $carrito->itemCarritos->sum('cantidad');
                $carrito->save();
            } else {
                // Si el carrito ya existe, verifica si el ItemCarrito ya existe
                $itemCarrito = ItemCarrito::where('carrito_id', $carrito->id)
                    ->where('producto_id', $request->producto_id)
                    ->first();

                // Si el ItemCarrito no existe, crea uno nuevo y agrega el elemento al ItemCarrito
                if (!$itemCarrito) {
                    $itemCarrito = new ItemCarrito([
                        'producto_id' => $request->producto_id,
                        'carrito_id' => $carrito->id,
                        'cantidad' => 1,
                        'precio' => $request->precio,
                    ]);
                    $itemCarrito->save();
                } else {
                    // Si el ItemCarrito ya existe, incrementa la cantidad del ItemCarrito
                    $itemCarrito->cantidad += 1;
                    $itemCarrito->save();
                }

                $carrito->num_elementos = $carrito->itemCarritos->sum('cantidad');
                $carrito->save();
            }
        }

        return redirect()->back()->with('success', 'El elemento se ha agregado al carrito');
    }
    public function restarElemento($id)
    {
        // Busca el ItemCarrito por su ID
        $itemCarrito = ItemCarrito::findOrFail($id);

        // Resta 1 a la cantidad del ItemCarrito
        $itemCarrito->cantidad -= 1;
        $itemCarrito->save();

        // Busca el carrito del usuario y actualiza el número de elementos
        $carrito = Carrito::findOrFail($itemCarrito->carrito_id);
        $carrito->num_elementos = $carrito->itemCarritos->sum('cantidad');
        $carrito->save();

        return redirect()->back()->with('success', 'El elemento se ha restado del carrito');
    }

    /**
     * Vacía el carrito del usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function vaciarCarrito()
    {
        // Busca el carrito del usuario
        $usuarioId = Auth::id();
        $carrito = Carrito::where('user_id', $usuarioId)->first();

        // Elimina todos los elementos del carrito
        $carrito->itemCarritos()->delete();

        // Actualiza el número de elementos del carrito a 0
        $carrito->num_elementos = 0;
        $carrito->save();

        return redirect()->back()->with('success', 'El carrito se ha vaciado');
    }
    /**
     * Cambia el estado del carrito a "pedido realizado".
     *
     * @return \Illuminate\Http\Response
     */
    public function realizarPedido()
    {
        // Busca el carrito del usuario
        $usuarioId = Auth::id();
        $carrito = Carrito::where('user_id', $usuarioId)->first();

        // Cambia el estado del carrito a "pedido realizado"
        $carrito->estado = 'pedido realizado';
        $carrito->save();

        return redirect()->back()->with('success', 'El pedido se ha realizado correctamente');
    }
}

