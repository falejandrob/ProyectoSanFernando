@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px;">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            <br>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            <br>
        @endif

        <div style="text-align: center">
            <h1>{{ $user->nombre . " " . $user->apellidos }}</h1>
            @if($user->hasRole('profesor'))
                <h3 style="color: rgb(167, 167, 167);">Profesor</h3>
            @elseif($user->hasRole('admin'))
                <h3 style="color: rgb(167, 167, 167);">Admin</h3>
            @endif
        </div>

        <div class="d-flex" style="padding: 25px">
            <div style="width: 35%; padding: 25px; background: #F6C366; padding-top: 50px;">
                <h2>Información personal</h2>
            </div>
            <div style="width: 65%; padding: 25px; background: #f6e9d2;">
                <form action="{{ route("perfil.cambiarDatos", ["id" => $user->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input style="font-size: 18px" type="text" name="nombre" id="nombre" class="form-control" value="{{$user->nombre}}">
                    </div><br>
                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input style="font-size: 18px" type="text" name="apellidos" id="apellidos" class="form-control" value="{{$user->apellidos}}">
                    </div><br>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input style="font-size: 18px" type="email" name="email" id="email" class="form-control" value="{{$user->email}}">
                    </div><br>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex" style="padding: 25px">
            <div style="width: 35%; padding: 25px; background: #F6C366; padding-top: 50px;">
                <h2>Cambiar contraseña</h2>
            </div>
            <div style="width: 65%; padding: 25px; background: #f6e9d2;">
                <form action="{{ route("perfil.cambiarPass", ["id" => $user->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label class="form-label">Contraseña actual</label>
                        <input style="font-size: 18px" type="password" name="lastPassword" id="lastPassword" class="form-control">
                    </div><br>
                    <div class="form-group">
                        <label class="form-label">Nueva contraseña</label>
                        <input style="font-size: 18px" type="password" name="password" id="password" class="form-control">
                    </div><br>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
