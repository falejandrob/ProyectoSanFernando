@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="width: 50%; margin: auto">
                    <h2 class="mt-4" style="text-align: center">Añadir proveedor</h2>
                    <hr>
                    <form   action="{{ route("proveedor.store") }}" method="post">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <label for="nombre" style="margin:15px 0px; font-size: 18px">Nombre</label>
                            <input style="font-size: 18px" type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" style="align-items: center">AÑADIR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
