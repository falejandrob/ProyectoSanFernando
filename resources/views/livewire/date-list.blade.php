<div>
    <div class="mt-2 table-responsive-md">
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="title-plazos" style="text-align: center; padding: 15px;">PLAZOS DE PEDIDOS</h1>
        @if($dates->count() > 0)
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table mb-0 tabla-scroll plazos" style="margin:auto; text-align: center; width: 90%">
                    <thead>
                    <tr>
                        <th>Fecha de apertura</th>
                        <th>Fecha de cierre</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dates as $date)
                        @php
                            $fechaConFormatoMin = \Carbon\Carbon::parse($date->fechaMinima)->format('d-m-Y');
                            $horaConFormatoMin = \Carbon\Carbon::parse($date->fechaMinima)->format('H:i');
                            $fechaConFormatoMax = \Carbon\Carbon::parse($date->fechaMaxima)->format('d-m-Y');
                            $horaConFormatoMax = \Carbon\Carbon::parse($date->fechaMaxima)->format('H:i');
                        @endphp

                        <tr class="table" style="text-align: center; background: #F6F0D2">
                            <td id="informacion" data-titulo="Fecha apertura:">{{$fechaConFormatoMin}} - {{$horaConFormatoMin}}h</td>
                            <td id="informacion" data-titulo="Fecha cierre:">{{$fechaConFormatoMax}} - {{$horaConFormatoMax}}h</td>
                            <td>
                                <button type="submit" class="btn btn-primary"><a
                                        style="color:white; text-decoration: none"
                                        href="{{route('updateDate', $date->id)}}">Modificar</a>
                                </button>
                            </td>
                            <td>
                                <button wire:click="destroyDate({{$date->id}})" class="btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
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
                    @if ($dates->currentPage() > 1)
                        <li class="page-item">
                            <a wire:click="gotoPage(1)" class="page-link">&laquo;&laquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="gotoPage(1)" class="page-link disabled">&laquo;&laquo;</a>
                        </li>
                    @endif
                    {{-- Botón de ir a la página anterior --}}
                    @if ($dates->currentPage() > 1)
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
                        $startPage = max($dates->currentPage() - floor($maxPaginasMostradas / 2), 1); // Página inicial a mostrar
                        $endPage = min($startPage + $maxPaginasMostradas - 1, $dates->lastPage()); // Página final a mostrar
                    @endphp
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item"><a wire:click="gotoPage({{ $i }})"
                                                 class="page-link{{ $i == $dates->currentPage() ? ' active' : '' }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Botón de ir a la página siguiente --}}
                    @if ($dates->hasMorePages())
                        <li class="page-item">
                            <a wire:click="nextPage" class="page-link">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="nextPage" class="page-link disabled">&raquo;</a>
                        </li>
                    @endif
                    {{-- Botón de ir a la última página --}}
                    @if ($dates->hasMorePages())
                        <li class="page-item">
                            <a wire:click="gotoPage({{ $dates->lastPage() }})" class="page-link">&raquo;&raquo;</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a wire:click="gotoPage({{ $dates->lastPage() }})" class="page-link disabled">&raquo;&raquo;</a>
                        </li>
                    @endif
                </ul>
            </nav>



            <br>
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay plazos de pedidos
                </div>
            </div>
        @endif
    </div>
</div>
