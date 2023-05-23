@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="btn-volver" style="margin: 20px 0px 0px 10px">
            <a class="btn btn-secondary" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>
        <div class="row" >
            <div class="col-md-12" style="justify-content: center">
                <div class="frm" style="margin: auto;">
                    <br>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h2 class="" style="text-align: center">Añadir plazo de pedido</h2>
                    <hr>
                    <form action="{{ route("fecha.store") }}" method="post">
                        @csrf
                        @method("POST")
                        <div class="form-group form-fecha" style=" margin: auto">
                            <label for="fechaMinima" style="margin:15px 0px; font-size: 18px">Fecha en la que se abre el plazo</label>
                            <input type="date" name="fechaMinima" id="fechaMinima" class="form-control" value="{{ $expectedDate }}">
                            <label for="horaMinima" style="margin:15px 0px; font-size: 18px">Hora en la que se abre el plazo</label>
                            <input type="time" name="horaMinima" id="horaMinima" class="form-control" value="{{ $expectedTime }}">
                            <label for="fechaMaxima" style="margin:15px 0px; font-size: 18px">Fecha en la que se cierra el plazo</label>
                            <input type="date" name="fechaMaxima" id="fechaMaxima" class="form-control" value="{{ $expectedDate }}">
                            <label for="horaMaxima" style="margin:15px 0px; font-size: 18px">Hora en la que se cierra el pazo</label>
                            <input type="time" name="horaMaxima" id="horaMaxima" class="form-control" value="{{ $expectedTime }}">
                            <br>
                            <div style="text-align: center">
                                <button type="submit" class="btn btn-primary">AÑADIR</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
