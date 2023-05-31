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

        <h1 style="text-align: center">PAPELERA DE PEDIDOS</h1>

        <br>
        @if (!empty($pedidos) && count($pedidos) > 0 )
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll ">
                    <thead>
                        <tr style="text-align: center">
                            <th scope="col">Profesor</th>
                            <th scope="col">Fecha pedido</th>
                            <th scope="col">Fecha prevista</th>
                            <th scope="col">Justificación</th>
                            <th scope="col">Restaurar</th>
                        </tr>
                    </thead>
                <tbody>
                @foreach($pedidos as $pedido)
                        <tr class="" style="text-align: center;">
                            <td id="informacion" data-titulo="Profesor:">{{ $profesores->where("id","=",$pedido->id)->first()->nombre . " ". $profesores->where("id","=",$pedido->id)->first()->apellidos }}</td>
                            <td id="informacion" data-titulo="Fecha pedido:">{{ explode(" ", $pedido->fechaPedido)[0] }}</td>
                            <td id="informacion" data-titulo="Fecha prevista:">{{ explode(" ", $pedido->fechaPrevistaPedido)[0] }}</td>
                            <td id="informacion" data-titulo="Justificacion:">{{ $pedido->justificacion }}</td>
                            <td id="informacion" data-titulo="Restaurar:">
                                <a type="button" class="btn btn-success" href="{{ route('restaurarPedido', $pedido->id) }}">
                                    Restaurar
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-repeat" viewBox="0 0 16 16">
                                        <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192Zm3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
                </table>
                <br>
            </div>
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay pedidos en la papelera
                </div>
            </div>
        @endif
    </div>
@endsection
