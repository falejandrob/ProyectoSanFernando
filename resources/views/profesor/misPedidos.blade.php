@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <h1 style="text-align: center">Mis pedidos</h1>
        <br>

        <table class="table" style="text-align: center">
            <thead>
                <tr>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Más detalles</th>
                    <th scope="col">Repetir pedido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $id => $pedido)
                    <tr>
                        <td>{{ $pedido->first()->options->get('fechaPedido') }}</td>
                        <td>{{ $pedido->first()->options->get('expectedDate') }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('detallesPedido', $id) }}">
                                Ver más
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{ route('repetirPedido', $id) }}">
                               Repetir pedido
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
