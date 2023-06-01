@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px;">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            <div class="d-flex justify-content-between">
                <div class="btn-volver" style="margin: 0px 0px 20px 0px">
                    <a class="btn btn-secondary" href="{{ route('home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Volver
                    </a>
                </div>
                <div class="btn-volver" style="margin: 0px 0px 20px 0px">
                    <a class="btn btn-primary" href="{{ route('realizarPedido')}}">
                        Nuevo pedido
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        <h1 style="text-align: center">Mis pedidos</h1>
        <br>

        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height: 500px">
            <table class="table mb-0 tabla-scroll " style="text-align: center;">
                <thead>
                <tr>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Justificación</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Enviar por correo</th>
                    <th scope="col">Imprimir</th>
                    <th scope="col">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                    @php
                        $eliminado = \App\Models\Pedido::findOrFail($id)->eliminado;
                    @endphp
                    @if($eliminado == 0)
                        @php
                            $validado = \App\Models\Pedido::findOrFail($id)->validado;
                            $fechaConFormato = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
                        @endphp
                        @if($validado == 0)
                            <tr class="" style="background: #ffffff">
                                <td id="informacion" data-titulo="Fecha pedido:" >{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido->first()->options->get('expectedDate') }}</td>
                                <td id="informacion" data-titulo="Justificación:"><a style="text-decoration: none; color: black;" href="{{ route('detallesPedido', [$id, ""]) }}">{{ $pedido->first()->options->get('justification') }}</a></td>
                                <td id="informacion" data-titulo="Estado del pedido:">En proceso</td>
                                <td id="botones">
                                    <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                        Detalles
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-success disabled">
                                        Enviar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-warning disabled">
                                        Imprimir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-danger" href="{{ route('eliminarPedidoProfesor', $id) }}">
                                        Eliminar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @elseif($validado == 2)
                            <tr class="" style="background: #FED2D2">
                                <td id="informacion" data-titulo="Fecha pedido:" >{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:" >{{ $pedido->first()->options->get('expectedDate') }}</td>
                                <td id="informacion" data-titulo="Justificación:" >
                                    <a style="text-decoration: none; color: black" href="{{ route('detallesPedido', [$id, ""]) }}">
                                        {{ $pedido->first()->options->get('justification') }}
                                    </a>
                                </td>
                                <td id="informacion" data-titulo="Estado del pedido:">Denegado</td>
                                <td id="botones">
                                    <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                        Detalles
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-success disabled">
                                        Enviar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-warning disabled">
                                        Imprimir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-danger" href="{{ route('eliminarPedidoProfesor', $id) }}">
                                        Eliminar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr class="" style="background: #BDDECA">
                                <td id="informacion" data-titulo="Fecha pedido:">{{ $fechaConFormato }}</td>
                                <td id="informacion" data-titulo="Fecha prevista:">{{ $pedido->first()->options->get('expectedDate') }}</td>
                                <td id="informacion" data-titulo="Justificación:">
                                    <a style="text-decoration: none; color: black" href="{{ route('detallesPedido', [$id, ""]) }}">
                                        {{ $pedido->first()->options->get('justification') }}
                                    </a>
                                </td>
                                <td id="informacion" data-titulo="Estado del pedido:">Validado</td>
                                <td id="botones">
                                    <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                        Detalles
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-success" href="{{route('sendMail',[$id])}}">
                                        Enviar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-warning" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                        Imprimir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td id="botones">
                                    <a class="btn btn-danger disabled">
                                        Eliminar
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
