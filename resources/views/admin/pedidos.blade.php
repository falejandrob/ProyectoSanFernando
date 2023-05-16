
@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 25px">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <br>
        @endif
        <h1 style="text-align: center">Total pedidos</h1>

        <br>
        @if(!empty($pedidos) && count($pedidos) > 0 )
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll ">
                <thead>
                <tr style="text-align: center">
                    <th scope="col">Profesor</th>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Ver más</th>
                    <th scope="col">Eliminación</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                    <tr style="text-align: center">
                        @php
                            $fechaConFormato = \Carbon\Carbon::parse($pedido[0]->first()->options->get('fechaPedido'))->format('d-m-Y');
                        @endphp
                        {{--@dd($profesores->where("id", "=", $pedidos->where('id','=',$id)->get()))--}}
                        {{--@dd($profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos)--}}
                        <td>{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                        <td>{{ $fechaConFormato }}</td>
                        <td>{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                Ver más
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{ route('eliminarPedido', $id)}}">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div>
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay pedidos
                </div>
            </div>
        @endif
    </div>
@endsection
