@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px;">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 style="text-align: center">Mis pedidos</h1>
        <br>

        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar" style="height: 400px">
            <table class="table mb-0 tabla-scroll " style="text-align: center;">
                <thead>
                <tr>
                    <th scope="col">Fecha pedido</th>
                    <th scope="col">Fecha prevista</th>
                    <th scope="col">Justificación</th>
                    <th scope="col">Más detalles</th>
                    <th scope="col">Enviar por correo</th>
                    <th scope="col">Imprimir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($paginatedData as $id => $pedido)
                    @php
                        $validado = \App\Models\Pedido::findOrFail($id)->validado;
                        $fechaConFormato = \Carbon\Carbon::parse($pedido->first()->options->get('fechaPedido'))->format('d-m-Y');
                    @endphp
                    @if($validado == 0)
                        <tr class="table-danger">
                            <td>{{ $fechaConFormato }}</td>
                            <td>{{ $pedido->first()->options->get('expectedDate') }}</td>
                            <td>{{ $pedido->first()->options->get('justification') }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                    Ver más
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger disabled">
                                    Enviar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success disabled">
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    @else
                        <tr class="table-success">
                            <td>{{ $fechaConFormato }}</td>
                            <td>{{ $pedido->first()->options->get('expectedDate') }}</td>
                            <td>{{ $pedido->first()->options->get('justification') }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('detallesPedido', [$id, ""]) }}">
                                    Ver más
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{route('sendMail',[$id])}}">
                                    Enviar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{route('downloadPdf',[$id])}}" target="_blank">
                                    Imprimir
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
            <div class="pagination" style="justify-content: center">
                {{ $paginatedData->links() }}
            </div>
    </div>
@endsection
