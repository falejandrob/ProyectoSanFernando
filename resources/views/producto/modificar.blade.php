@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Modificar un producto</h2>
                <hr>
                <form  action="{{ route("producto.update", ["id" => $producto->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="nombre" style="margin:15px 0px;">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{$producto->nombre}}">
                    </div>
                    <div>
                        <label for="categoria" style="margin:15px 0px;">Categoría</label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="idCategoria">
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p>
                            Sube una imagen:
                            <input type="file" name="foto" accept="image/png, .jpeg, .jpg, image/gif" >
                        </p>
                    </div>
                    <div class="form-group">
                        <td><button type="submit" class="btn btn-primary">MODIFICAR</button></td>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
