@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div>{{session('message')}}</div>
    @endif

    <div class="d-flex justify-content-around" style="flex-wrap: wrap">
        <div class="busqueda" style="margin-top: 25px">
            @livewire('productos-buscar')
        </div>

        <div class="carrito" style="background: #FAFAFA; border-left: #D6D6D6 1px solid; padding: 25px">
            @livewire('cart-list')
        </div>
    </div>
@endsection


<!-- Escribir justificacion modal -->
<div class="modal fade modal-lg" id="justificacionModal" tabindex="-1" aria-labelledby="justificacionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="justificacionModal">Justificación pedido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('addJustificacion')}}" method="post">
                <div class="modal-body">
                    <div class="input-group">
                    <textarea class="form-control" id="justificacion" placeholder="Justificacion"
                              name="justificacion" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    @csrf
                    @method("GET")
                    <button class="btn btn-primary" type="submit">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal realizar pedido -->
<div class="modal fade modal-lg" id="confirmarPedido" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmar pedido</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('cart.confirm')}}" method="post">
                    @csrf
                    @method("GET")
                    <div class="form-row">
                        <div class="mb-3">
                            <label>Para cuando se quiere el pedido</label>
                            <input type="date" class="form-control" id="expectedDate" name="expectedDate" pattern="\d{4}-\d{2}-\d{2}" value="{{ $expectedDate }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Para que hora</label>
                            <input type="time" class="form-control" id="expectedTime" name="expectedTime" value="{{ $expectedTime }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Justificación</label>
                            <textarea class="form-control" id="justification" placeholder="Justificacion"
                                      name="justification" required>{{ Session::get("justificacion") }}</textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Hacer pedido</button>
                </form>
            </div>
        </div>
    </div>
</div>
