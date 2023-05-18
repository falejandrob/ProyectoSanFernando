@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto">
                    <h2 class="mt-4" style="text-align: center">Modificar profesor</h2>
                    <hr>
                    <form action="{{ route("profesor.update", ["id" => $profesor->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method("POST")
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
                        <div class="form-group">
                            <label for="presupuesto" style="margin:15px 0px; font-size: 18px">Presupuesto</label>
                            <input style="font-size: 18px" type="number" name="presupuesto" id="presupuesto" class="form-control"
                                   value="{{ $presupuesto }}">
                        </div>
                        <div class="form-group">
                            <label for="rol" style="margin:15px 0px; font-size: 18px">Rol</label>
                            @if($profesor->hasRole('profesor'))
                                <div class="d-flex">
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="admin">
                                        <label class="form-check-label" for="admin">
                                            admin
                                        </label>
                                    </div>
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="profesor" checked>
                                        <label class="form-check-label" for="profesor">
                                            profesor
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @if($profesor->hasRole('admin'))
                                <div class="d-flex">
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="admin" checked>
                                        <label class="form-check-label" for="admin">
                                            admin
                                        </label>
                                    </div>
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="profesor">
                                        <label class="form-check-label" for="profesor">
                                            profesor
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <br>
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-primary">MODIFICAR</button>
                        </div><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
