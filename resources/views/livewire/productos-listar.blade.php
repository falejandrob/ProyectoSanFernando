<div class="productos" style="padding: 25px">
    <div class="mt-2 table-responsive-md">
        <div >
            <div class="col-md-1" style="display: flex">
                <label for="idCatgeroia" class="form-label" style="margin-right:5px">Categorías</label>
                <div class="col-xs-10">
                    <select class="block w-full" wire:model="categoryFilter">
                        <option value="">Todas</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="col-md-2">
                <label for="validado" class="form-check-label">Sin validar</label>
                <input wire:model="validateFilter" type="checkbox" class="form-check-input" id="validado">
            </div>

        </div>
        <h1 style="text-align: center; padding: 15px">PRODUCTOS</h1>
        <div
            style="width: 50%; margin: auto; border: 2px solid #F6C366; border-radius: 50px; height: 40px; display: flex; justify-content: space-around; align-items: center;">
            <input wire:model="searchFilter" type="text"  id="searchFilter"
                   style="width: 65%; height: 25px; font-size: 150%; text-align: center; outline: none; border: 2px solid white; background: white"/>
            <img src="https://cdn-icons-png.flaticon.com/512/3917/3917132.png" style="height: 25px;"/>
        </div><br>
        @if($productos && $productos->count() > 0)
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table mb-0 tabla-scroll " style="width:100%; margin:auto; text-align: center;">
                <thead style="position: static">
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
                                <button wire:click.prevent="destroyProduct({{$producto->id}})" class="btn btn-danger">
                                    ELIMINAR
                                </button>
                            </td>

                            <td>
                                <button type="submit" class="btn btn-primary"><a
                                        style="color:white; text-decoration: none"
                                        href="{{route('modificarProducto',$producto->id)}}">MODIFICAR</a>
                                </button>
                            </td>
                            <td>
                                @csrf
                                @method('POST')
                                @if($producto->validado == 1)
                                    <button wire:click.prevent="validateProduct({{$producto->id}})"
                                            class="btn btn-success">VALIDAR
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>

        <br>
        @else
            <div class="alert"
                 style="text-align: center; font-size: 120%; border: solid 2px #C80000; background: #F3D8D8">
                No hay productos
            </div>
        @endif
    </div>
</div>
