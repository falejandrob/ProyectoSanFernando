@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <h1 style="text-align: center">Mis pedidos</h1>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Justificacion</th>
                    <th scope="col">Mas detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <th scope="row">{{ $pedido->id }}</th>
                        <td>{{ $pedido->fechaPedido }}</td>
                        <td>{{ $pedido->fechaPrevistaPedido }}</td>
                        <td>{{ $pedido->observaciones }}</td>
                        <td>{{ $pedido->justificacion }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('detallesPedido', $pedido->id) }}">
                                Ver más
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
