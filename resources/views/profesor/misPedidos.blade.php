@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px;">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="btn-volver" style="margin: 0px 0px 20px 0px">
                <a class="btn btn-secondary" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Volver
                </a>
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
                    <th scope="col">Estado del pedido</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Enviar por correo</th>
                    <th scope="col">Imprimir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pedidos as $id => $pedido)
                    @php
                        $validado = \App\Models\Pedido::findOrFail($id)->validado;
                        $fechaConFormato = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
                    @endphp
                    @if($validado == 0)
                        <tr class="" style="background: #ffffff">
                            <td id="informacion" data-titulo="Fecha pedido:" >{{ $fechaConFormato }}</td>
                            <td id="informacion" data-titulo="Fecha prevista:" >{{ $pedido->first()->options->get('expectedDate') }}</td>
                            <td id="informacion" data-titulo="Justificación:" >
                                <a style="text-decoration: none; color: black" href="{{ route('detallesPedido', [$id, ""]) }}">
                                    {{ $pedido->first()->options->get('justification') }}
                                </a></td>
                            <td id="informacion" data-titulo="Estado del pedido:">En proceso</td>
                            <td id="botones">
                                <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                    Detalles
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-success disabled">
                                    Enviar
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-danger disabled">
                                    Imprimir
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
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-success disabled">
                                    Enviar
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-danger disabled">
                                    Imprimir
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
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-success" href="{{route('sendMail',[$id])}}">
                                    Enviar
                                </a>
                            </td>
                            <td id="botones">
                                <a class="btn btn-danger" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
