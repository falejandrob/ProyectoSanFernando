@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div>{{session('message')}}</div>
    @endif
    <div style="display: flex; width: 90%; margin:auto;">
        <div class="productos" style="width: 100%; padding: 15px; margin: 0 auto;">
            @livewire('productos-buscar')
        </div>
    </div>


@endsection
