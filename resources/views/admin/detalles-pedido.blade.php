@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">

        <h1 style="text-align: center">Pedido {{ $idPedido }}</h1>

        <br>

        <h2 style="text-align: center">Detalles</h2>
        <hr>
        @php
            $fechaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
            $horaConFormatoPedido = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('H:i');

            $fechaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedDate'))->format('d-m-Y');
            $horaConFormatoPrevista = \Carbon\Carbon::parse($pedido->first()->options->get('expectedTime'))->format('H:i');
        @endphp
        <p id="detalles">Profesor que realiza el pedido: {{$profesor}}</p>
        <p id="detalles">Fecha pedido: {{ $fechaConFormatoPedido }} - {{ $horaConFormatoPedido }}h</p>
        <p id="detalles">Fecha prevista: {{ $fechaConFormatoPrevista }} - {{$horaConFormatoPrevista}}h</p>
        <p id="detalles">Justificación: {{ $pedido->first()->options->get('justification') }}</p>
        <br><br>

        <h2 style="text-align: center">Productos</h2>
        <hr>
<!---->
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
