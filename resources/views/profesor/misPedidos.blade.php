@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px; ">
        <h1 style="text-align: center">Mis pedidos</h1>
        <br>

        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height: 400px">
            <table class="table mb-0 tabla-scroll " style="text-align: center;">
                <thead>
                <tr>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Más detalles</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
