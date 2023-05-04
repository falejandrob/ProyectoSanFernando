@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <h1 style="text-align: center">Mis pedidos</h1>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Justificacion</th>
                    <th scope="col">Mas detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $id => $pedido)
                    <tr>
                        <td>{{ $pedido->first()->options->get('fechaPedido') }}</td>
                        <td>{{ $pedido->first()->options->get('expectedDate') }}</td>
                        <td>{{ $pedido->first()->observaciones }}</td>
                        <td>{{ $pedido->first()->options->get('justification') }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('detallesPedido', $id) }}">
                                Ver más
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
