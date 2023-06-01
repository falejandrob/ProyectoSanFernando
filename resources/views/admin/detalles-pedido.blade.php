@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <div class="btn-volver" style="margin: 0px 0px 20px 0px">
            <a class="btn btn-secondary" href="{{ route('totalPedidos') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>
        <h1 style="text-align: center">Pedido {{ $idPedido }}</h1>

        <br>

        <div class="btn-detalles">
            <div>
                <h2>Detalles</h2>
            </div>
            <div class="detalles-botones">
                <a class="btn btn-success" href="{{ route('seleccionarProveedores', $idPedido)}}" style="font-size: 16px;padding: 8px">
                    Proveedores
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                </a>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#imprimir{{$idPedido}}" style="font-size: 16px; padding: 8px">
                    Imprimir
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    </svg>
                </button>
                <a class="btn btn-danger" href="{{ route('eliminarPedido', $idPedido) }}" style="font-size: 16px; padding: 8px">
                    Eliminar
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24"
                         style="fill:#FFFFFF;">
                        <path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"></path>
                    </svg>
                </a>
            </div>
        </div>
        <hr>
        @php
            $fechaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d/m/Y');
            $horaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('H:i');

            $fechaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedDate'))->format('d/m/Y');
            $horaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedTime'))->format('H:i');
        @endphp
        <p id="detalles">Profesor que realiza el pedido: {{$profesor}}</p>
        <p id="detalles">Fecha pedido: {{ $fechaConFormatoPedido }} - {{ $horaConFormatoPedido }}h</p>
        <p id="detalles">Fecha prevista: {{ $fechaConFormatoPrevista }} - {{$horaConFormatoPrevista}}h</p>
        <p id="detalles">Justificación: {{ $pedido->first()->options->get('justification') }}</p>
        <br><br>

        <h2 style="text-align: center">Productos</h2>
        <hr>

        @if(count($pedido) == 0)
            <h3>El pedido no tiene ningun producto</h3>
        @else
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll" style="text-align: center; font-size: 120%">
                    <thead>
                    <tr>
                        <th scope="col">Nombre producto</th>
                        <th scope="col">Categoria producto</th>
                        <th scope="col">Cantidad</th>
                        <th>I</th>
                        <th>R</th>
                        <th scope="col">Observación</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pedido as $linea)
                        <tr>
                            <td id="informacion" data-titulo="Nombre:">{{ $linea->name }}</td>
                            <td id="informacion" data-titulo="Categoría:">{{ $linea->options->categoria }}</td>
                            <td id="informacion" data-titulo="Cantidad:">{{ $linea->qty }}</td>
                            <td id="informacion" data-titulo="Incidencia:"></td>
                            <td id="informacion" data-titulo="Respuesta:"></td>
                            <td id="informacion" data-titulo="Observación:">{{ $linea->options->observacion}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

<div class="modal fade" id="imprimir{{$idPedido}}" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validateModalLabel">Imprimir pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content: center;">
                <a class="btn btn-success"  style="margin:2%" href="{{route('downloadProvPdf',[$idPedido])}}" target="_blank">
                    Imprimir con proveedores
                </a>
                <a class="btn btn-success" style="margin:2%" href="{{route('downloadPdf',[$idPedido])}}" target="_blank">
                    Imprimir sin proveedores
                </a>
            </div>
        </div>
    </div>
</div>
