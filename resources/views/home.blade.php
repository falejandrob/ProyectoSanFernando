@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div>{{session('message')}}</div>
    @endif

    <div class="d-flex justify-content-around" style="flex-wrap: wrap">
        <div class="busqueda" style="margin-top: 25px">
            @livewire('productos-buscar')
        </div>
        @if($closestDate !== null)
            @if($fechaActual->between($closestDate->fechaMinima,$closestDate->fechaMaxima))
                <div class="carrito" style="background: #FAFAFA; border-left: #D6D6D6 1px solid; padding: 25px">
                    @livewire('cart-list')
                </div>
            @endif
        @endif
    </div>
@endsection



