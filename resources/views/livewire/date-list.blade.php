<div>
    <div class="mt-2 table-responsive-md">
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="btn-volver" style="margin: 0px 0px 20px 20px">
            <a class="btn btn-secondary" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>
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
                            $fechaConFormatoMin = \Carbon\Carbon::parse($date->fechaMinima)->format('d/m/Y');
                            $horaConFormatoMin = \Carbon\Carbon::parse($date->fechaMinima)->format('H:i');
                            $fechaConFormatoMax = \Carbon\Carbon::parse($date->fechaMaxima)->format('d/m/Y');
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
