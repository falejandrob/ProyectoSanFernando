@extends('layouts.app')

@section('content')
    <div style="width: 100%;">
        @if (session('success'))
            <div class="alert alert-success" style="width: 60%; margin: auto; margin-top: 2%">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="btn-volver" style="margin: 25px">
        <a class="btn btn-secondary" href="{{ route('totalPedidos') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
            </svg>
            Volver
        </a>
    </div>
    <div class="container d-flex justify-content-around align-items-center"
         style="border: black solid 1px; background: rgb(237, 237, 237); padding: 10px; width: 90%">
        <div style="width: 50%">
            <form action="{{ route('establecerProveedor') }}" method="POST">
                <input type="hidden" name="id" value="{{ $idPedido }}" id="id">
                @csrf
                @php($categoriasMostradas = [])
                <p id="title-categories" style="margin-top: 25px; font-weight: bold; text-align: center">Productos</p>
            @foreach ($lineasPedido as $linea)
                    @foreach($categorias as $categoria)
                        @if(App\Models\Producto::find($linea->idProducto)->idCategoria == $categoria->id && !in_array($categoria->id, $categoriasMostradas))
                            <p id="title-categories" style="margin-top: 25px; font-weight: bold; text-align: center">{{ $categoria->nombre }}</p>
                            @php(array_push($categoriasMostradas, $categoria->id))
                        @endif
                    @endforeach
                    @php($esta = false)
                    @foreach ($productosConProveedor as $item)
                        @if ($item->lineaPedido == $linea->id)
                            <div class="proveedores" style="margin: 8px; margin-left: 20px;">
                                <a class="btn btn-danger" href="{{ route('quitarRelacion', $item->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                         class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                    </svg>
                                </a>
                                <span>{{ App\Models\Producto::find($linea->idProducto)->nombre }}</span>
                                <span
                                    class="badge bg-dark">{{ App\Models\Proveedore::find($item->proveedor)->nombre }}</span>
                            </div>
                            @php($esta = true)
                        @endif
                    @endforeach
                    @if(!$esta)
                        <div class="proveedores" style="margin: 8px; margin-left: 20px;">
                            <input style="width: 20px; height: 20px; cursor: pointer;" type="checkbox"
                                   name="productos[]" value="{{ $linea->id }}">
                            <span>{{ App\Models\Producto::find($linea->idProducto)->nombre }}</span>
                        </div>
            @endif
            @endforeach
        </div>
        <div style="width: 50%;">
            <p id="title-categories" style="margin-top: 25px; font-weight: bold; text-align: center">Proveedores</p>
        @foreach ($proveedores as $proveedor)
                <div class="proveedores" style="margin-left:20px;">
                    <input style="width: 20px; height: 20px; cursor: pointer;" type="radio" name="proveedor"
                           value="{{ $proveedor->id }}">
                    {{ $proveedor->nombre }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center" style="margin: 25px;">
        <button type="submit" class="btn btn-primary btn-lg">Guardar proveedor</button>
    </div>
    </form>
@endsection
