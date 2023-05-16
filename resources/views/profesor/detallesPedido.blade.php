@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <!--<a class="btn btn-secondary" href="{{ route('misPedidos', Auth::user()->id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            Volver
        </a>-->

        <h1 style="text-align: center">Pedido {{ $idPedido }}</h1>

        <br>

        <div style="display: flex; justify-content: space-between">
            <h2>Detalles</h2>
            <a class="btn btn-success" href="{{ route('repetirPedido', $idPedido) }}" style="font-size: 16px">
                Repetir pedido
            </a>
        </div>
        <hr>
        @php
            $fechaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
            $horaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('H:i');

            $fechaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedDate'))->format('d-m-Y');
            $horaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedTime'))->format('H:i');
        @endphp
        <h3>Fecha pedido: {{ $fechaConFormatoPedido }} - {{ $horaConFormatoPedido }}h</h3>
        <h3>Fecha prevista: {{ $fechaConFormatoPrevista }} - {{$horaConFormatoPrevista}}h</h3>
        <h3>Justificación: {{ $pedido->first()->options->get('justification') }}</h3>

        <br><br>

        <h2>Productos</h2>
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
                            <td>{{ $linea->name }}</td>
                            <td>{{ $linea->options->categoria }}</td>
                            <td>{{ $linea->qty }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $linea->options->observacion }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
