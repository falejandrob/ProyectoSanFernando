@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row" >
            <div class="col-md-12" style="justify-content: center">
                <div style="width: 60%; margin: auto;">
                    <h2 class="mt-4" style="text-align: center">Añadir fecha límite</h2>
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
