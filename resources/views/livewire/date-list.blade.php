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
                <table class="table mb-0 tabla-scroll plazos" style="margin:auto; text-align: center;">
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
                            <td>{{$fechaConFormatoMin}} - {{$horaConFormatoMin}}</td>
                            <td>{{$fechaConFormatoMax}} - {{$horaConFormatoMax}}</td>
                            <td>
                                <button type="submit" class="btn btn-primary"><a
                                        style="color:white; text-decoration: none"
                                        href="{{route('updateDate', $date->id)}}">MODIFICAR</a>
                                </button>
                            </td>
                            <td>
                                <button wire:click="destroyDate({{$date->id}})" class="btn btn-danger">
                                    ELIMINAR
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="width: 60%; margin: auto">
                <div class="alert alert-danger" style="text-align: center; font-size: 120%">
                    No hay plazos de pedidos
                </div>
            </div>
        @endif
    </div>
</div>
