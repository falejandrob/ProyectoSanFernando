<div style="width: 100%" >
    <div class="mt-2 table-responsive-md" >
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="btn-volver" style="margin: 0px 0px 0px 30px">
            <a class="btn btn-secondary" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>
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
                        <td id="informacion" data-titulo="Nombre:">{{$proveedor->nombre}}</td>
                        <td >
                            <button type="submit" class="btn btn-primary"><a
                                    style="color:white; text-decoration: none"
                                    href="{{route('modificarProveedor', $proveedor->id)}}">Modificar</a>
                            </button>
                        </td>
                        <td >
                            <button wire:click="destroyProveedor({{$proveedor->id}})" class="btn btn-danger">
                                Eliminar
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
