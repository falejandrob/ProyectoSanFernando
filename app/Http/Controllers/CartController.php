<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        //dd(Cart::content());
        //dd($request);
        $fecha = strtotime($request->expectedDate);
        $fechaConFormato = date('d-m-Y',$fecha );
        foreach (Cart::content() as $item){
            $producto = Producto::findOrFail($item->id);
            Cart::update($item->rowId, ['options' => [
                'categoria'=>Categoria::findOrFail($producto->idCategoria)->nombre,
                'expectedDate' => $fechaConFormato,
                'expectedTime' => $request->expectedTime,
                'justification' => $request->justification,
                'fechaPedido' => Carbon::now()->format('d-m-Y')
            ]]);
        }
        //dd(Cart::content());
        Session::forget("justificacion");
        $dateTimeJustification =[
            'expectedDate' => Carbon::parse($request->expectedDate)->format('d/m/Y'),
            'expectedTime'=>$request->expectedTime,
            'justification'=>$request->justification,
        ];
        $productos = Cart::content();
        /*$header = "<header>
              <table>
                  <tbody>
                      <tr>
                          <td rowspan='3'><img src='data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/logo.png')))}}' style='width: 100%'></td>
                          <td rowspan='3' style='text-align: center'>Hoja de pedido</td>
                          <td>Documento</td>
                          <td>Norma</td>
                      </tr>
                      <tr>
                          <td>DC1231451431</td>
                          <td>ISO 9001:2015</td>
                      </tr>
                      <tr>
                          <td>Rev.3</td>
                          <td id='page-number'></td>
                      </tr>
                  </tbody>
              </table>
          </header>";*/
        $pdf = Pdf::loadView('pdf.productos', compact('productos', 'dateTimeJustification'));
        store(Auth::id());
        Cart::destroy();
        $pdf->download('invoice.pdf');
       //return $pdf->stream();
        session()->flash('success', 'El pedido se ha realizado correctamente.');
        return redirect()->route('misPedidos', [Auth::id()]);
    }

    function eliminarPedido($id)
    {

        //$instance =  "default";

        //DB::connection()->table('shoppingcart')->where(['identifier' => $identifier, 'instance' => $instance])->delete();
        DB::connection()->table('shoppingcart')->where("id", "=", $id)->delete();
        //return view('admin.pedidos');
        return redirect()->action([HomeController::class, 'totalPedidos']);
    }

    function repetirPedido($id)
    {
        $content = Cart::content();
        //dd($content);
        $stored = DB::connection()->table('shoppingcart')
            ->where(['id'=> $id])->first();

        if (DB::connection()->getDriverName() === 'pgsql') {
            $storedContent = unserialize(base64_decode(data_get($stored, 'content')));
        } else {
            $storedContent = unserialize(data_get($stored, 'content'));
        }

        if(Cart::content()){
            Cart::destroy();
        }

        foreach ($storedContent as $cartItem) {
            $content->put($cartItem->rowId, $cartItem);
            Cart::add(['rowId'=>$cartItem->rowId,'id'=>$cartItem->id,'qty'=>$cartItem->qty, 'name'=>$cartItem->name, 'price'=>0.0,'weight'=>0.0,'options'=>['categoria'=>$cartItem->options->categoria, 'expectedDate'=>$cartItem->options->expectedDate,'expectedTime'=>$cartItem->options->expectedTime,'justification'=>$cartItem->options->justification,'fechaPedido'=>$cartItem->options->fechaPedido]]);
        }
        //dd(Cart::content());
        //dd($content);

        // return redirect()->action();
        return redirect()->action([HomeController::class, 'index']);

    }

//    public function confirm(Request $request)
//    {
//        //Data
//        $dateTimeJustification =[
//            'expectedDate' => Carbon::parse($request->expectedDate)->format('d/m/Y'),
//            'expectedTime'=>$request->expectedTime,
//            'justification'=>$request->justification,
//        ];
//        $productos = Cart::content();
//
//        //Instance dompdf
//        $dompdf = new Dompdf();
//        //Header
//        $header = '<header>
//              <table>
//                  <tbody>
//                      <tr>
//                          <td rowspan="3"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path(´/logo.png´)))}}" style="width: 100%"></td>
//                          <td rowspan="3" style="text-align: center">Hoja de pedido</td>
//                          <td>Documento</td>
//                          <td>Norma</td>
//                      </tr>
//                      <tr>
//                          <td>DC1231451431</td>
//                          <td>ISO 9001:2015</td>
//                      </tr>
//                      <tr>
//                          <td>Rev.3</td>
//                          <td id="page-number"></td>
//                      </tr>
//                  </tbody>
//              </table>
//          </header>';
//
//        // set the options for the PDF generation
//
//        $options = new \Dompdf\Options();
//        $options->setIsPhpEnabled(true);
//        $options->set('isRemoteEnabled', true);
//        $options->set('defaultFont', 'Arial');
//        $options->set('isHtml5ParserEnabled', true);
//        $options->set('enable_html5_parser', true);
//
//        // set the header to appear on every page
//        $options->set('isPhpEnabled', true);
//        $options->set('header-html', $header);
//        $options->set('header-spacing', '5');
//
//        // set the options for the DOMPDF instance
//        $dompdf->setOptions($options);
//
//        // load the HTML content
//        $html = "<html lang='en'>
//<head>
//    <meta charset='UTF-8'>
//    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
//    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//    <title>Hoja de pedido</title>
//    <style>
//        table {
//            width: 100%;
//        }
//
//        table, td, th {
//            border: 1px solid #595959;
//            border-collapse: collapse;
//        }
//
//        td, th {
//            padding: 3px;
//            width: 30px;
//            height: 25px;
//        }
//
//        th {
//            background: #f0e6cc;
//        }
//
//        .even {
//            background: #fbf8f0;
//        }
//
//        .odd {
//            background: #fefcf9;
//        }
//    </style>
//</head>
//<body>
//<!---->
//<br>
//<p>PROFESOR/A QUE REALIZA EL PEDIDO: <strong>{{auth()->user()->nombre}} {{auth()->user()->apellidos}}</strong></p>
//<p>FECHA DEL PEDIDO: <strong>{{ now()->format('d/m/Y') }}</strong></p>
//<p>FECHA PARA LA QUE SE SOLICITA EL PEDIDO: <strong>{{$dateTimeJustification['expectedDate']}}</strong></p>
//<p>HORA PARA LA QUE SE SOLICITA EL PEDIDO: <strong>{{$dateTimeJustification['expectedTime']}}</strong></p>
//<p>JUSTIFICACION: <strong>{{$dateTimeJustification['justification']}}</strong></p>
//<table>
//    <thead>
//    <tr>
//        <th>Artículo</th>
//        <th>Cantidad</th>
//    </tr>
//    </thead>
//    <tbody>
//    @php
//        $categorias = array();
//    @endphp
//    @foreach($productos as $producto)
//        @php
//            $categoria = $producto->options->categoria;
//        @endphp
//        @if(!in_array($categoria, $categorias))
//            @php
//                $categorias[] = $categoria;
//            @endphp
//            <tr style='text-align: center' class='hover'>
//                <td><strong>{{ $categoria }}</strong></td>
//                <td></td>
//            </tr>
//        @endif
//        <tr style='text-align: center' class='hover'>
//            <td>{{ $producto->name }}</td>
//            <td>{{ $producto->qty }} ud</td>
//        </tr>
//    @endforeach
//    </tbody>
//</table>
//
//</body>
//</html>";
//        $dompdf->loadHtml($html);
//        $dompdf->render();
//        Cart::destroy();
//        return $dompdf->stream('document.pdf', ['Attachment' => false]);
//    }


}
function store()
{
    $pedido = new Pedido();

    $pedido->idUser = Auth::id();
    $pedido->fechaPedido = Carbon::now();
    $pedido->fechaPrevistaPedido = Carbon::parse(Cart::content()->first()->options->expectedDate . Cart::content()->first()->options->expectedTime);
    $pedido->justificacion = Cart::content()->first()->options->justification;
    $pedido->save();

    foreach (Cart::content() as $cartItem) {
        $pedidoItem = new LineaPedido();
        //dd(Cart::content());
        $pedidoItem->idPedido = $pedido->id;
        $pedidoItem->idProducto = $cartItem->id;
        $pedidoItem->cantidad = $cartItem->qty;
        $pedidoItem->observaciones = $cartItem->options->observaciones;
        $pedidoItem->save();

    }
}

