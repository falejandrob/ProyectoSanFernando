@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 25px">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <br>
        @endif
            <div class="btn-volver" style="margin: 0px 0px 20px 0px">
                <a class="btn btn-secondary" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Volver
                </a>
            </div>
        <h1 style="text-align: center">TOTAL PEDIDOS</h1>

        <br>
        @if (!empty($pedidos) && count($pedidos) > 0 )
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll ">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col">Profesor</th>
                            <th scope="col">Fecha pedido</th>
                            <th scope="col">Fecha prevista</th>
                            <th scope="col">Estado del pedido</th>
                            <th scope="col">Detalles</th>
                            <th scope="col">Validar / Desvalidar</th>
                            <th scope="col">Proveedores</th>
                            <th scope="col">Imprimir</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                        @php
                            $validado = \App\Models\Pedido::findOrFail($id)->validado;
                            $fechaConFormato = \Carbon\Carbon::parse($pedido[0]->first()->options->get('fechaPedido'))->format('d-m-Y');
                        @endphp
                        @if ($validado == 0 || $validado == 2)
                            <tr class="" style="text-align: center;background:#FED2D2">
                                {{--@dd($profesores->where("id", "=", $pedidos->where('id','=',$id)->get()))--}}
                                {{--@dd($profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos)--}}
                                <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                                <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                                <td id="informacion" data-titulo="Estado del pedido:">Sin validar</td>
                                <td id="botones-pedidos">
                                    <a class="btn btn-primary"
                                    href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                        Detalles
                                    </a>
                                </td>
                                <td id="botones-pedidos">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#validateModal{{$id}}">
                                        Validar
                                    </button>
                                </td>
                                <td id="botones-pedidos">
                                    <a class="btn btn-info disabled" href="{{ route('seleccionarProveedores', $id)}}" style="color:white; background: #01B3E3; border: none">
                                        Proveedores
                                    </a>
                                </td>
                                <!--<td id="botones-pedidos">
                                    <a class="btn btn-danger" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                        Imprimir
                                    </a>
                                </td>-->
                                <td id="botones-pedidos">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#imprimir{{$id}}">
                                        Imprimir
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr class="" style="text-align: center; background: #BDDECA ">
                                <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                                <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                                <td id="informacion" data-titulo="Estado del pedido:">Validado</td>
                                <td id="botones-pedidos">
                                    <a class="btn btn-primary"
                                    href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                        Detalles
                                    </a>
                                </td>
                                <td id="botones-pedidos">
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#validateModal{{$id}}">
                                        Corregir
                                    </button>
                                </td>
                                <td id="botones-pedidos">
                                    <a class="btn " href="{{ route('seleccionarProveedores', $id)}}"  style="color:white; background: #01B3E3; border: none">
                                        Proveedores
                                    </a>
                                </td>
                                <!--<td id="botones-pedidos">
                                    <a class="btn btn-danger" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                        Imprimir
                                    </a>
                                </td>-->
                                <td id="botones-pedidos">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#imprimir{{$id}}">
                                        Imprimir
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <!-- Modal -->
                    <div class="modal fade" id="validateModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validateModalLabel">¿Esta bien el pedido?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-success" href="{{ route('validarPedido', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre, $profesores->where("id","=",$pedido[1])->first()->apellidos, $profesores->where("id","=",$pedido[1])->first()->email])}}">
                                        Si
                                    </a>
                                    <a class="btn btn-danger" href="{{ route('desvalidarPedido', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre, $profesores->where("id","=",$pedido[1])->first()->apellidos, $profesores->where("id","=",$pedido[1])->first()->email])}}">
                                        No
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="validateModal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validateModalLabel">¿Esta bien el pedido?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-success" href="{{ route('validarPedido', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre, $profesores->where("id","=",$pedido[1])->first()->apellidos, $profesores->where("id","=",$pedido[1])->first()->email])}}">
                                        Si
                                    </a>
                                    <a class="btn btn-danger" href="{{ route('desvalidarPedido', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre, $profesores->where("id","=",$pedido[1])->first()->apellidos, $profesores->where("id","=",$pedido[1])->first()->email])}}">
                                        No
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="imprimir{{$id}}" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="validateModalLabel">Imprimir pedido</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="display:flex; justify-content: center;">
                                    <a class="btn btn-success"  style="margin:2%" href="{{route('downloadProvPdf',[$id])}}" target="_blank">
                                        Imprimir con proveedores
                                    </a>
                                    <a class="btn btn-success" style="margin:2%" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                        Imprimir sin proveedores
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
