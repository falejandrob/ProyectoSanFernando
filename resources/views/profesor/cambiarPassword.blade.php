@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto;">
                    <div class="btn-volver" style="margin: 20px 0px 20px 0px">
                        <a class="btn btn-secondary" href="{{ route('listarProfesores') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                    <h2 class="mt-4" style="text-align: center">Modificar Contraseña</h2>
                    <hr>
                    <form action="{{ route("profesor.pass", ["id" => $profesor->id])}}"
                          method="post">
                        @csrf
                        @method("POST")
                        <div class="form-group" >
                            <label for="dni" style="margin:15px 0px; font-size: 18px">Nueva Contraseña</label>
                            <input  type="password" name="password" id="password" class="form-control"
                                   value="">
                        </div>
                        <br>
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-primary">MODIFICAR CONTRASEÑA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
