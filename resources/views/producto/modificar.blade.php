@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="frm" style="margin: auto">
                    <h2 class="mt-4" style="text-align: center">Modificar producto</h2>
                    <hr>
                    <form action="{{ route("producto.update", ["id" => $producto->id]) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <label for="nombre" style="margin:15px 0px; font-size: 18px">Nombre</label>
                            <input style="font-size: 18px" type="text" name="nombre" id="nombre" class="form-control"
                                   value="{{$producto->nombre}}">
                        </div>
                        <div>
                            <label for="categoria" style="margin:15px 0px; font-size: 18px">Categoría</label>
                            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                    name="idCategoria">
                                @foreach($categorias as $categoria)
                                    <option <?php if($categoria->id == $producto->idCategoria){echo("selected");}?> value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                @endforeach
                            </select>
                        </div><br>
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-primary" style="align-items: center">MODIFICAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---->
@endsection
