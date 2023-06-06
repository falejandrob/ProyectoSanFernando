@extends('layouts.app')
@section('content')
    <div class="container" style="padding: 25px">
        <div class="btn-volver" style="margin: 0px 0px 20px 0px">
            <a class="btn btn-secondary" href="{{ route('home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Volver
            </a>
        </div>

        <h1 style="text-align: center;">INFORMES SEGÚN PROFESOR</h1>

        <br>
        <form action="{{ route("informesProfesorResultado") }}" method="post">
            @csrf
            @method("POST")
            <div class="form-group form-fecha" style=" margin: auto; display: flex;">
                <select class="form-select" name="user">
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}">{{ $profesor->nombre . " " . $profesor->apellidos}}</option>
                    @endforeach
                </select>
                <br>
                <div style="text-align: center">
                    <button type="submit" class="btn btn-primary">CALCULAR</button>
                </div>
                <br>
            </div>
        </form>

        <br>
        @if($user != "")
            @if(count($labelsProductos) != 0)
                <h3 style="text-align: center;">Productos más pedidos de {{ $user }}</h3>
                <div style="width: 60%; margin: auto;">
                    <canvas id="productos"></canvas>
                </div>
                <h3 style="text-align: center;">Categorias más pedidas de {{ $user }}</h3>
                <div style="width: 60%; margin: auto;">
                    <canvas id="categorias"></canvas>
                </div>
            @else
                <h4 style="text-align: center;">El profesor {{ $user }} no ha hecho ningún pedido</h4>
            @endif
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxProductos = document.getElementById('productos');

        new Chart(ctxProductos, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsProductos); ?>,
                datasets: [{
                    label: 'cantidad',
                    data: <?php echo json_encode($dataProductos); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        const ctxCategorias = document.getElementById('categorias');

        new Chart(ctxCategorias, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsCategorias); ?>,
                datasets: [{
                    label: 'cantidad',
                    data: <?php echo json_encode($dataCategorias); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
@endsection
