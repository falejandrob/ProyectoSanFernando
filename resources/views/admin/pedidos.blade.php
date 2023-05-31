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
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                        @php
                            $eliminado = \App\Models\Pedido::findOrFail($id)->eliminado;
                        @endphp
                        @if ($eliminado == 0)
                            @php
                                $validado = \App\Models\Pedido::findOrFail($id)->validado;
                                $fechaConFormato = \Carbon\Carbon::parse($pedido[0]->first()->options->get('fechaPedido'))->format('d-m-Y');
                            @endphp
                            @if ($validado == 0 || $validado == 2)
                                <tr class="" style="text-align: center;background:#FED2D2">
                                    <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos }}</td>
                                    <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                    <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido[0]->first()->options->get('expectedDate') }}</td>
                                    <td id="informacion" data-titulo="Estado del pedido:">Sin validar</td>
                                    <td id="botones-pedidos">
                                        <a class="btn btn-primary"
                                        href="{{ route('detallesPedidoAdmin', [$id, $profesores->where("id","=",$pedido[1])->first()->nombre . " ". $profesores->where("id","=",$pedido[1])->first()->apellidos]) }}">
                                            Detalles
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-lg" viewBox="0 0 16 16">
                                                <path d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704l1.323-6.208Zm.091-2.755a1.32 1.32 0 1 1-2.64 0 1.32 1.32 0 0 1 2.64 0Z"/>
                                            </svg>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td id="botones-pedidos">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#imprimir{{$id}}">
                                            Imprimir
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td id="botones-pedidos">
                                        <a type="button" class="btn btn-danger" href="{{ route('eliminarPedido', $id) }}">
                                            Eliminar
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24"style="fill:#FFFFFF;">
                                                <path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"></path>
                                            </svg>
                                        </a>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-lg" viewBox="0 0 16 16">
                                                <path d="m9.708 6.075-3.024.379-.108.502.595.108c.387.093.464.232.38.619l-.975 4.577c-.255 1.183.14 1.74 1.067 1.74.72 0 1.554-.332 1.933-.789l.116-.549c-.263.232-.65.325-.905.325-.363 0-.494-.255-.402-.704l1.323-6.208Zm.091-2.755a1.32 1.32 0 1 1-2.64 0 1.32 1.32 0 0 1 2.64 0Z"/>
                                            </svg>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td id="botones-pedidos">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#imprimir{{$id}}">
                                            Imprimir
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td id="botones-pedidos">
                                        <a type="button" class="btn btn-danger" href="{{ route('eliminarPedido', $id) }}">
                                            Eliminar
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24"style="fill:#FFFFFF;">
                                                <path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endif
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
