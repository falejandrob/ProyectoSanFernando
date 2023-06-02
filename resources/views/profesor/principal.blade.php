@extends('layouts.app')

@section('content')

    <div class="container-fluid card-admin" style="width: 100%;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                margin-top:3%; margin-bottom: 2%">
        <div class="card border-success mb-3 cd-admin" style="margin:2%;">
            <a title="Realizar pedido" href="{{ route('realizarPedido') }}" style="text-align: center"><img class="card-img-top" src="productos.png" alt="Card image cap"  style="margin-top: 5%;height: auto;max-width: 40%; min-width: 40%; align-self: center"></a>
            <div class="card-body text-success">
                <p class="card-text" style="text-align: center"><a style="text-decoration: none; color: darkgreen" class="card-text" href="{{ route('realizarPedido')}}">Realizar pedido</a></p>
            </div>
        </div>
        <div class="card border-success mb-3 cd-admin" style="margin:2%;">
            <a title="Mis pedidos" href="{{route('misPedidos', Auth::user()->id)}}" style="text-align: center"><img class="card-img-top" src="pedido.png" alt="Card image cap"  style="margin-top: 5%;height: auto;max-width: 40%; min-width: 40%; align-self: center"></a>
            <div class="card-body text-success">
                <p class="card-text" style="text-align: center"><a style="text-decoration: none; color: darkgreen" class="card-text" href="{{route('misPedidos', Auth::user()->id)}}">Mis pedidos</a></p>
            </div>
        </div>
    </div>
@endsection
