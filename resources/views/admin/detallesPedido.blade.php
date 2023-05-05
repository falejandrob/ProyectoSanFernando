@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">

        <h1 style="text-align: center">Pedido {{ $idPedido }}</h1>

        <br>

        <h2>Detalles</h2>
        <hr>
        <h3>Fecha pedido: {{ $pedido->first()->options->get('fechaPedido') }}</h3>
        <h3>Fecha prevista: {{ $pedido->first()->options->get('expectedDate') }}</h3>
        <h3>Observaciones: {{ $pedido->first()->observaciones }}</h3>
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pedido as $linea)
                        <tr>
                            <td>{{ $linea->name }}</td>
                            <td>{{ $linea->options->categoria }}</td>
                            <td>{{ $linea->qty }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
