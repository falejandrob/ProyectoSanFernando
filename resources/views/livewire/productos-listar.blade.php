<div class="productos" style="padding: 20px">
    <div class="mt-2 table-responsive-md">
        <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                <br>
            @endif
            <div class="btn-volver" style="margin: 10px 0px 30px 0px">
                <a class="btn btn-secondary" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Volver
                </a>
            </div>

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
        <br>
        <div class="mb-3 d-flex justify-content-start align-items-center">
            <label class="form-label">Número de productos por página</label>
            <select class="form-select" wire:model="porPagina" style="width: 100px; margin-left: 10px;">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
            </select>
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
                        <th wire:click="ordenarAlfabeticamente()" style="cursor: pointer;">
                            Nombre
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </th>
                        <th>Categoría</th>
                        <th>Modificar producto</th>
                        <th>Validar producto</th>
                        <th>Eliminar producto</th>
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
                                        <button type="submit" class="btn btn-primary"><a
                                                style="color:white; text-decoration: none"
                                                href="{{route('modificarProducto',$producto->id)}}">Modificar</a>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td id="botones">
                                        @csrf
                                        @method('POST')

                                        <button wire:click.prevent="validateProduct({{$producto->id}})"
                                                class="btn btn-success" @if($producto->validado == 0) disabled @endif>Validar
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                                                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
                                                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td id="botones">
                                        <button wire:click.prevent="destroyProduct({{$producto->id}})"
                                                class="btn btn-danger">
                                            Eliminar
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                            </svg>
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
