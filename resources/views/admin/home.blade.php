@extends('layouts.app')

@section('content')
    <div class="container-fluid card-admin" style="width: 100%;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                margin-top:3%; margin-bottom: 2%">
        @if(auth()->user()->hasRole('admin'))
            <div class="card border-success mb-3 cd-admin" style="margin:2%;">
                <a title="Profesores" href="{{ route('listarProfesores') }}" style="text-align: center"> <img class="card-img-top" src="profesores.png" alt="Card image cap" style="margin-top: 5%;height: auto;max-width: 40%; min-width: 40%; align-self: center"></a>
                <div class="card-body text-success">
                    <p class="card-text" style="text-align: center;"><a style="text-decoration: none; color: darkgreen" class="card-text" href="{{ route('listarProfesores') }}">Profesores</a></p>
                </div>
            </div>
        @endif
        <div class="card border-success mb-3 cd-admin" style="margin:2%;">
            <a title="Pedidos" href="{{route('totalPedidos')}}" style="text-align: center"><img class="card-img-top" src="pedido.png" alt="Card image cap"  style="margin-top: 5%;height: auto;max-width: 40%; min-width: 40%; align-self: center"></a>
            <div class="card-body text-success">
                <p class="card-text" style="text-align: center"><a style="text-decoration: none; color: darkgreen" class="card-text" href="{{route('totalPedidos')}}">Pedidos</a></p>
            </div>
        </div>
        <div class="card border-success mb-3 cd-admin" style="margin:2%;">
            <a title="Productos" href="{{ route('listarProductos') }}" style="text-align: center"><img class="card-img-top" src="productos.png" alt="Card image cap"  style="margin-top: 5%;height: auto;max-width: 40%; min-width: 40%; align-self: center"></a>
            <div class="card-body text-success">
                <p class="card-text" style="text-align: center"><a style="text-decoration: none; color: darkgreen" class="card-text" href="{{ route('listarProductos') }}">Productos</a></p>
            </div>
        </div>
        <div class="card border-success mb-3 cd-admin" style="margin:2%;">
            <a title="Proveedores" href="{{ route('listarProveedores') }}" style="text-align: center"><img class="card-img-top" src="camion.png" alt="Card image cap"  style="margin-top: 5%;height: auto;max-width: 40%;  min-width: 40%; align-self: center"></a>
            <div class="card-body text-success">
                <p class="card-text" style="text-align: center"><a style="text-decoration: none; color: darkgreen" class="card-text"  href="{{ route('listarProveedores') }}">Proveedores</a></p>
            </div>
        </div>
    </div>
@endsection
