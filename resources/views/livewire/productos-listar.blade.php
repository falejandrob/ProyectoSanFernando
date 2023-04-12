<div>
    <h1 style="text-align: center; padding: 15px">PRODUCTOS</h1>
    <table class="table" style="width:50%; margin:auto; text-align: center;">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Borrar producto</th>
            <th>Modificar producto</th>
            <th>Validar producto</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productos as $producto)
            @if($producto->validado == 1)
                <tr class="table-danger" style="text-align: center">
            @else
                <tr class="table-success" style="text-align: center">
                    @endif
                    <td>{{$producto->id}}</td>
                    <td>{{$producto->nombre}}</td>
                    @foreach($categorias as $categoria)
                        @if($producto->idCategoria == $categoria->id)
                            <td>{{$categoria->nombre}}</td>
                        @endif
                    @endforeach
                    <td>
                        <button wire:click="destroyProduct({{$producto->id}})" class="btn btn-danger">ELIMINAR</button>
                    </td>

                    <td>
                        <button type="submit" class="btn btn-primary"><a style="color:white; text-decoration: none"
                                                                         href="{{route('modificarProducto',$producto->id)}}">MODIFICAR</a>
                        </button>
                    </td>
                    <td>
                        @if($producto->validado == 1)
                            <button wire:click.prevent="validateProduct({{$producto->id}})" class="btn btn-success">VALIDAR</button>
                        @endif
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    <br>
</div>
