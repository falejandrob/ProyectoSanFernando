@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">

        <div class="btn-volver" style="margin: 0px 0px 20px 0px">
            <a class="btn btn-secondary" href="{{ route('misPedidos', Auth::user()->id) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>
        <h1 style="text-align: center">Pedido {{ $idPedido }}</h1>

        <br>
        <div style="display: flex; justify-content: space-between">
            <h2>Detalles</h2>
           <div>
               <a class="btn btn-success" href="{{ route('repetirPedido', $idPedido) }}" style="font-size: 16px">
                   Repetir pedido
               </a>
               @php
                   $validado = \App\Models\Pedido::findOrFail($idPedido)->validado;
               @endphp
               @if($validado == 0 or $validado == 2)
                   <a class="btn btn-danger" href="{{ route('eliminarPedidoProfesor', $idPedido) }}" style="font-size: 16px">
                       <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24"
                            style="fill:#FFFFFF;">
                           <path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"></path>
                       </svg>
                   </a>
               @endif


      </div>
   </div>
   <hr>
   @php
       $fechaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
       $horaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('H:i');

       $fechaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedDate'))->format('d-m-Y');
       $horaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedTime'))->format('H:i');
        @endphp
        <p id="detalles">Fecha pedido: {{ $fechaConFormatoPedido }} - {{ $horaConFormatoPedido }}h</p>
        <p id="detalles">Fecha prevista: {{ $fechaConFormatoPrevista }} - {{$horaConFormatoPrevista}}h</p>
        <p id="detalles">Justificación: {{ $pedido->first()->options->get('justification') }}</p>

        <br>

        <h2 style="text-align: center">Productos</h2>
        <hr>
<!---->
        @if(count($pedido) == 0)
            <h3>El pedido no tiene ningun producto</h3>
        @else
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll" style="text-align: center; font-size: 120%">
                    <thead>
                    <tr>
                        <th scope="col">Nombre producto</th>
                        <th scope="col">Categoria producto</th>
                        <th scope="col">Cantidad</th>
                        <th>I</th>
                        <th>R</th>
                        <th scope="col">Observación</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pedido as $linea)
                        <tr>
                            <td id="informacion" data-titulo="Nombre:">{{ $linea->name }}</td>
                            <td id="informacion" data-titulo="Categoría:">{{ $linea->options->categoria }}</td>
                            <td id="informacion" data-titulo="Cantidad:">{{ $linea->qty }}</td>
                            <td id="informacion" data-titulo="Incidencia:"></td>
                            <td id="informacion" data-titulo="Respuesta:"></td>
                            <td id="informacion" data-titulo="Observación:">{{ $linea->options->observacion}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
