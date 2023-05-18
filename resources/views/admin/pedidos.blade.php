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
        @if (!empty($pedidos) && count($pedidos) > 0 )
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll ">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col">Profesor</th>
                            <th scope="col">Fecha pedido</th>
                            <th scope="col">Fecha prevista</th>
                            <th scope="col">Ver más</th>
                            <th scope="col">Eliminar</th>
                            <th scope="col">Validar / Desvalidar</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                        @php
                            $validado = \App\Models\Pedido::findOrFail($id)->validado;
                            $fechaConFormato = \Carbon\Carbon::parse($pedido[0]->first()->options->get('fechaPedido'))->format('d-m-Y');
                        @endphp
                        @if ($validado == 0)
                            <tr class="" style="text-align: center;background:#FED2D2">
                                {{--@dd($profesores->where("id", "=", $pedidos->where('id','=',$id)->get()))--}}
                                {{--@dd($profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos)--}}
                                <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                                <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                                <td id="botones">
                                    <a class="btn btn-primary"
                                    href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                        Ver más
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-danger" href="{{ route('eliminarPedido', $id)}}">
                                        Eliminar
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-success" href="{{ route('validarPedido', $id)}}">
                                        Validar
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr class="" style="text-align: center; background: #BDDECA ">
                                {{--@dd($profesores->where("id", "=", $pedidos->where('id','=',$id)->get()))--}}
                                {{--@dd($profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos)--}}
                                <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                                <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                                <td id="botones">
                                    <a class="btn btn-primary"
                                    href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                        Ver más
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-danger" href="{{ route('eliminarPedido', $id)}}">
                                        Eliminar
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-dark" href="{{ route('desvalidarPedido', $id)}}">
                                        Desvalidar
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                @endforeach
                </table>
                <br>
            </div>
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay pedidos
                </div>
            </div>
        @endif
    </div>
@endsection
