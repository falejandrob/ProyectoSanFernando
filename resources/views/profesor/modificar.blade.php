@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto">
                    <div class="btn-volver" style="margin: 20px 0px 20px 0px">
                        <a class="btn btn-secondary" href="{{ route('listarProfesores') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Volver
                        </a>
                    </div>
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
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="gestor">
                                        <label class="form-check-label" for="gestor">
                                            gestor
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
                            @if($profesor->hasRole('gestor'))
                                <div class="d-flex">
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="admin">
                                        <label class="form-check-label" for="admin">
                                            admin
                                        </label>
                                    </div>
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="gestor" checked>
                                        <label class="form-check-label" for="gestor">
                                            gestor
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
                            @if($profesor->hasRole('admin'))
                                <div class="d-flex">
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="admin" checked>
                                        <label class="form-check-label" for="admin">
                                            admin
                                        </label>
                                    </div>
                                    <div class="form-check" style="margin: 5px">
                                        <input class="form-check-input" type="radio" name="rol" id="rol" value="gestor">
                                        <label class="form-check-label" for="gestor">
                                            gestor
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
