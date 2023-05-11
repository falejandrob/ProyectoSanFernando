<div>
    <div class="mt-2 table-responsive-md">
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 style="text-align: center; padding: 15px">PROVEEDORES</h1>
        @if($proveedores->count() > 0)
            <table class="table" style="width:80%; margin:auto; text-align: center;">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proveedores as $proveedor)

                    <tr class="table" style="text-align: center; background: #F6F0D2">
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
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                   No hay proveedores
                </div>
            </div>
        @endif
    </div>
</div>
