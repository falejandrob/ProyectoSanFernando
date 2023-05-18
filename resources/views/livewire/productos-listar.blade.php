<div class="productos" style="padding: 25px">
    <div class="mt-2 table-responsive-md">
        <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                <br>
            @endif
            <div class="col-md-1" style="display: flex">
                <label for="idCatgeroia" class="form-label" style="margin-right:5px">Categorías</label>
                <div class="col-xs-10">
                    <select class="block w-full" wire:model="categoryFilter" style="width: 180px">
                        <option value="">Todas</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="col-md-2">
                <label for="validado" class="form-check-label">Sin validar</label>
                <input wire:model="validateFilter" type="checkbox" class="form-check-input" id="validado">
            </div>

        </div>
        <h1 style="text-align: center; padding: 15px">PRODUCTOS</h1>
        <div
            class="inp-busqueda" style="margin: auto; border: 2px solid #F6C366; border-radius: 50px; height: 40px;
             display: flex; justify-content: space-around; align-items: center;">
            <input wire:model="searchFilter" type="text" id="searchFilter"
                   style="width: 65%; height: 25px; font-size: 150%; text-align: center; outline: none; border: 2px solid white; background: white"/>
            <img src="https://cdn-icons-png.flaticon.com/512/3917/3917132.png" style="height: 25px;"/>
        </div>
        <br>
        @if($productos && $productos->count() > 0)
            <div class="">
                <table class="table" style="width:100%; margin:auto; text-align: center;">
                    <thead style="position: static">
                    <tr>
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
                            <tr class="" style="background: #FED2D2">
                        @else
                            <tr class="" style="background: #BDDECA" >
                                @endif
                                <td id="informacion" data-titulo="Nombre:" >{{$producto->nombre}}</td>
                                @foreach($categorias as $categoria)
                                    @if($producto->idCategoria == $categoria->id)
                                        <td id="informacion" data-titulo="Categoría:">{{$categoria->nombre}}</td>
                                    @endif
                                @endforeach
                                <div>
                                    <td id="botones">
                                        <button wire:click.prevent="destroyProduct({{$producto->id}})"
                                                class="btn btn-danger">
                                            Eliminar
                                        </button>
                                    </td>

                                    <td id="botones">
                                        <button type="submit" class="btn btn-primary"><a
                                                style="color:white; text-decoration: none"
                                                href="{{route('modificarProducto',$producto->id)}}">Modificar</a>
                                        </button>
                                    </td>
                                    <td id="botones">
                                        @csrf
                                        @method('POST')

                                        <button wire:click.prevent="validateProduct({{$producto->id}})"
                                                class="btn btn-success" @if($producto->validado == 0) disabled @endif>Validar
                                        </button>

                                    </td>
                                </div>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            {{-- Botones de paginación --}}
            <nav>
                <ul class="pagination justify-content-center">
                    {{-- Botón de ir a la primera página --}}
                    @if ($productos->currentPage() > 1)
                        <li class="page-item">
                            <a wire:click="gotoPage(1)" class="page-link">&laquo;&laquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="gotoPage(1)" class="page-link disabled">&laquo;&laquo;</a>
                        </li>
                    @endif
                    {{-- Botón de ir a la página anterior --}}
                    @if ($productos->currentPage() > 1)
                        <li class="page-item">
                            <a wire:click="previousPage" class="page-link">&laquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="previousPage" class="page-link disabled">&laquo;</a>
                        </li>
                    @endif
                    {{-- Botones de las páginas --}}
                    @php
                        $startPage = max($productos->currentPage() - floor($maxPaginasMostradas / 2), 1); // Página inicial a mostrar
                        $endPage = min($startPage + $maxPaginasMostradas - 1, $productos->lastPage()); // Página final a mostrar
                    @endphp
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item"><a wire:click="gotoPage({{ $i }})"
                                                 class="page-link{{ $i == $productos->currentPage() ? ' active' : '' }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Botón de ir a la página siguiente --}}
                    @if ($productos->hasMorePages())
                        <li class="page-item">
                            <a wire:click="nextPage" class="page-link">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="nextPage" class="page-link disabled">&raquo;</a>
                        </li>
                    @endif
                    {{-- Botón de ir a la última página --}}
                    @if ($productos->hasMorePages())
                        <li class="page-item">
                            <a wire:click="gotoPage({{ $productos->lastPage() }})" class="page-link">&raquo;&raquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="gotoPage({{ $productos->lastPage() }})" class="page-link disabled">&raquo;&raquo;</a>
                        </li>
                    @endif
                </ul>
            </nav>



            <br>
        @else
            <div class="alert"
                 style="text-align: center; font-size: 120%; border: solid 2px #C80000; background: #F3D8D8">
                No hay productos
            </div>
        @endif
    </div>
</div>
