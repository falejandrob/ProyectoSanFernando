@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row" >
            <div class="col-md-12" style="justify-content: center">
                <div style="width: 50%; margin: auto;">
                    <h2 class="mt-4" style="text-align: center">Añadir fecha límite</h2>
                    <hr>
                    <form action="{{ route("fecha.store") }}" method="post">
                        @csrf
                        @method("POST")
                        <div class="form-group form-fecha" style=" margin: auto">
                            <label for="fecha" style="margin:15px 0px; font-size: 18px">Fecha</label>
                            <input type="date" name="fechaMaxima" id="fechaMaxima" class="form-control" value="{{ $expectedDate }}">
                            <label for="hora" style="margin:15px 0px; font-size: 18px">Hora</label>
                            <input type="time" name="horaMaxima" id="horaMaxima" class="form-control" value="{{ $expectedTime }}">
                            <br>
                            <div  style="margin: auto">
                                <button type="submit" class="btn btn-primary">AÑADIR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
