@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto">
                    <br>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
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
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-primary">AÑADIR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
