@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 25px">
        {{-- <div style="display: flex">
            <div style="width: 50%;">
                @foreach($pedido as $linea)
                    <div class="form-check" style="font-size: 150%">
                        <input class="form-check-input" type="checkbox" id="{{ $linea->id }}" value="{{ $linea->id }}">
                        {{ $linea->name . " - " . $linea->options->categoria . " - " . $linea->qty . "ud." }}
                    </div>
                @endforeach
            </div>

            <div style="width: 50%;">
                @foreach($proveedores as $proveedor)
                    <div style="font-size: 150%; text-align: center;">
                        {{ $proveedor->nombre }}
                    </div>
                @endforeach
            </div>
        </div>

        <br>

        <div style="display: flex; justify-content: center;">
            <a class="btn btn-primary btn-lg" id="botonAceptar" href="{{ route('establecerProveedor') }}">
                Establecer proveedor
            </a>
        </div> --}}

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('establecerProveedor') }}" method="POST">
                        <input type="hidden" name="id" value="{{ $idPedido }}" id="id">
                        @csrf
                        @foreach ($pedido as $linea)
                            @if (in_array($linea->id, $productosConProveedor))
                                <div style="font-size: 150%">
                                    {{ $linea->name }}
                                </div>
                            @else
                                <div style="font-size: 150%">
                                    <input type="checkbox" name="productos[]" value="{{ $linea->id }}">
                                    {{ $linea->name }}
                                </div>
                            @endif
                        @endforeach
                </div>
                <div class="col-md-6">
                        @foreach ($proveedores as $proveedor)
                            <div style="font-size: 150%">
                                <input type="radio" name="proveedor" value="{{ $proveedor->id }}">
                                {{ $proveedor->nombre }}
                            </div>
                        @endforeach
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar proveedor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
