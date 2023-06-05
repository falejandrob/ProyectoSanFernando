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

            <div class="btn-volver" style="margin: 20px 0px 20px 5%">
                <a class="btn btn-secondary" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Volver
                </a>
            </div>
        <div style="text-align: center">
            <h1>{{ $user->nombre . " " . $user->apellidos }}</h1>
            @if($user->hasRole('profesor'))
                <h3 style="color: rgb(167, 167, 167);">Profesor</h3>
            @elseif($user->hasRole('admin'))
                <h3 style="color: rgb(167, 167, 167);">Admin</h3>
            @elseif($user->hasRole('gestor'))
                <h3 style="color: rgb(167, 167, 167);">Gestor</h3>
            @endif
        </div>

        <div class="datos-personales" style="padding: 25px">
            <div class="cajon1" style="padding: 25px; background: #F6C366; padding-top: 50px;">
                <h2>Información personal</h2>
            </div>
            <div class="cajon2" style="padding: 25px; background: #f6e9d2;">
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
                        <button type="submit" class="btn btn-primary">
                            GUARDAR
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="datos-personales" style="padding: 25px;">
            <div class="cajon1" style="padding: 25px; background: #F6C366; padding-top: 50px;">
                <h2>Cambiar contraseña</h2>
            </div>
            <div class="cajon2" style="padding: 25px; background: #f6e9d2;">
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
                        <button type="submit" class="btn btn-primary">
                            GUARDAR
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
