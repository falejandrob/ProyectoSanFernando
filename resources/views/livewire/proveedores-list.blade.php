<div>
    <div class="mt-2 table-responsive-md">
        <h1 style="text-align: center; padding: 15px">PROFESORES</h1>
        <table class="table" style="width:80%; margin:auto; text-align: center;">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($proveedores as $proveedor)
                <tr class="table" style="text-align: center; background: #F6F0D2">
                    <td>{{$proveedor->id}}</td>
                    <td>{{$proveedor->nombre}}</td>
                    <td>
                        <button type="submit" class="btn btn-primary"><a
                                style="color:white; text-decoration: none"
                                href="{{route('modificarProveedor', $proveedor->id)}}">MODIFICAR</a>
                        </button>
                    </td>
                    <td>
                        <button wire:click="destroyProveedor({{$proveedor->id}})" class="btn btn-danger">
                            ELIMINAR
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
