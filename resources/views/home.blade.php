@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div>{{session('message')}}</div>
    @endif

    <div style="width: 70%; margin: auto">
        @livewire('cart-list')
    </div>
@endsection

<!-- Modal añadir productos al carro -->
<div class="modal fade modal-xl" id="productosModal" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir productos al carro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('productos-buscar')
            </div>
        </div>
    </div>
</div>

<!-- Modal realizar pedido -->
<div class="modal fade" id="confirmarPedido" data-bs-backdrop="true" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                    @method("POST")
                    <div class="form-row">
                        <div class="mb-3">
                            <label>Para cuando se quiere el pedido</label>
                            <input type="date" class="form-control" id="expectedDate" name="expectedDate" pattern="\d{4}-\d{2}-\d{2}" required>
                        </div>
                        <div class="mb-3">
                            <label>Para que hora</label>
                            <input type="time" class="form-control" id="expectedTime" name="expectedTime" required>
                        </div>
                        <div class="mb-3">
                            <label>Justificación</label>
                            <textarea class="form-control" id="justification" placeholder="Justificacion"
                                      name="justification" required></textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Hacer pedido</button>
                </form>
            </div>
        </div>
    </div>
</div>
