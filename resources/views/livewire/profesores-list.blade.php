<div>
    <div class="mt-2 table-responsive-md">
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 style="text-align: center; padding: 15px">PROFESORES</h1>
        <div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 550px">
            <table class="table mb-0 tabla-scroll " style="width:90%; margin:auto; text-align: center;">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Cambiar contraseña</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
                @foreach($profesores as $profesor)
                        <tr class="table" style="text-align: center; background: #F6F0D2">
                            <td id="informacion" data-titulo="Nombre:">{{$profesor->nombre}}</td>
                            <td id="informacion" data-titulo="Apellidos:">{{$profesor->apellidos}}</td>
                            <td id="informacion" data-titulo="Email:">{{$profesor->email}}</td>
                            <td id="boton-contrasenia">
                                <button type="submit" class="btn btn-success"><a
                                        style="color:white; text-decoration: none"
                                        href="{{route('cambiarPassword', $profesor->id)}}">Cambiar contraseña</a>
                                </button>
                            </td>
                            <td >
                                <button type="submit" class="btn btn-primary"><a
                                        style="color:white; text-decoration: none"
                                        href="{{route('modificarProfesor', $profesor->id)}}">Modificar</a>
                                </button>
                            </td>
                            <td >
                                <button wire:click="destroyProfesor({{$profesor->id}})" class="btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <br>

    <div class="d-flex justify-content-center">
        {{ $profesores->links() }}
    </div>
</div>
