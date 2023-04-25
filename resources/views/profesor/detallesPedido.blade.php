@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <a class="btn btn-secondary" href="{{ route('misPedidos', Auth::user()->id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            Volver
        </a>

        <h1 style="text-align: center">Pedido {{ $pedido->id }}</h1>

        <br>

        <h2>Detalles</h2>
        <hr>
        <h3>Fecha pedido: {{ $pedido->fechaPedido }}</h3>
        <h3>Fecha prevista: {{ $pedido->fechaPrevistaPedido }}</h3>
        <h3>Observaciones: {{ $pedido->observaciones }}</h3>
        <h3>Justificación: {{ $pedido->justificacion }}</h3>

        <br><br>

        <h2>Lineas pedido</h2>
        <hr>

        @if(count($lineasPedido) == 0)
            <h3>El pedido no tiene ninguna línea</h3>
        @else
            <table class="table" style="text-align: center; font-size: 120%">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Id producto</th>
                    <th scope="col">Nombre producto</th>
                    <th scope="col">Categoria producto</th>
                    <th scope="col">Cantidad</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lineasPedido as $linea)
                    <tr>
                        <th scope="row">{{ $linea->id }}</th>
                        <td>{{ $linea->idProducto }}</td>
                        <td>{{ \App\Models\Producto::find($linea->idProducto)->nombre }}</td>
                        <td>{{ \App\Models\Categoria::find(\App\Models\Producto::find($linea->idProducto)->idCategoria)->nombre }}</td>
                        <td>{{ $linea->cantidad }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
