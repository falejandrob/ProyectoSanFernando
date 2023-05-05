@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 25px">
        <h1 style="text-align: center">Total pedidos</h1>

        <br>
        @if(count($pedidos) > 0)

        <table class="table">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Profesor</th>
                <th scope="col">Fecha pedido</th>
                <th scope="col">Fecha prevista</th>
                <th scope="col">Observaciones</th>
                <th scope="col">Justificacion</th>
                <th scope="col">Ver más</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pedidos as $id => $pedido)
                <tr style="text-align: center">
                    {{--@dd($profesores->where("id", "=", $pedidos->where('id','=',$id)->get()))--}}
                    {{--@dd($profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos)--}}
                    <td>{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                    <td>{{ $pedido[0]->first()->options->get('fechaPedido') }}</td>
                    <td>{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                    <td>{{ $pedido[0]->first()->observaciones }}</td>
                    <td>{{ $pedido[0]->first()->options->get('justification') }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('detallesPedido', $id) }}">
                            Ver más
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay pedidos
                </div>
            </div>
        @endif
    </div>
@endsection
