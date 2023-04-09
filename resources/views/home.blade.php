@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div>{{session('message')}}</div>
    @endif
<div style="display: flex; width: 90%; margin:auto;">
    <div class="lista" style="width: 30%; padding: 15px">
        @livewire('cart-list')
    </div>


    <div class="productos" style="width: 70%; padding: 15px">
        @livewire('productos-buscar')
    </div>
</div>
@livewireScripts
@endsection
