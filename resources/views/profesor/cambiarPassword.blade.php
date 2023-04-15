@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Modificar Contraseña</h2>
                <hr>
                <br>
                <form class="form-floating" action="{{ route("profesor.pass", ["id" => $profesor->id])}}" method="post">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="dni">Nueva Contraseña</label>
                        <input style="width: 30%" type="password" name="password" id="password" class="form-control" value="">
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">MODIFICAR CONTRASEÑA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
