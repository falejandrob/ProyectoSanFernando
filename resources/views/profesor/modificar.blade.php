@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="width: 50%; margin: auto">
                    <h2 class="mt-4" style="text-align: center">Modificar producto</h2>
                    <hr>
                    <form action="{{ route("profesor.update", ["id" => $profesor->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <label for="nick" style="margin:15px 0px; font-size: 18px">Nick</label>
                            <input style="font-size: 18px" type="text" name="nick" id="nick" class="form-control"
                                   value="{{$profesor->nick}}">
                        </div>
                        <div class="form-group">
                            <label for="nombre" style="margin:15px 0px; font-size: 18px">Nombre</label>
                            <input style="font-size: 18px" type="text" name="nombre" id="nombre" class="form-control"
                                   value="{{$profesor->nombre}}">
                        </div>
                        <div class="form-group">
                            <label for="apellidos" style="margin:15px 0px; font-size: 18px">Apellidos</label>
                            <input style="font-size: 18px" type="text" name="apellidos" id="apellidos" class="form-control"
                                   value="{{$profesor->apellidos}}">
                        </div>
                        <div class="form-group">
                            <label for="email" style="margin:15px 0px; font-size: 18px">Email</label>
                            <input style="font-size: 18px" type="email" name="email" id="email" class="form-control"
                                   value="{{$profesor->email}}">
                        </div>
                        <button type="submit" class="btn btn-primary" style="align-items: center">MODIFICAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
