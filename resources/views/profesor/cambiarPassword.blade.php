@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto;">
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
