<div style="width: 100%; margin: auto">
    <form action="{{route('cart.confirm')}}" method="post">
        @csrf
        @method("POST")
        <div>
            @if(Cart::content()->count() != 0 && $closestDate !== null)
                <div style="display: flex; justify-content: space-between;">
                    <div style="margin-top: 2%">
                        <p class="carrito-size" style="text-align: center; font-size: 22px; font-weight: bold;">Tu pedido</p>
                    </div>
                    <button wire:click.prevent="clearCart()"
                            class="btn btn-danger d-flex justify-content-between align-items-center" style="margin-left: 20%; height: 5%">
                        <span style="padding: 5px">Vaciar Carrito</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                    </button>
                </div><hr>
                <div>
                    <label class="carrito-size" style="margin-bottom: 2%">Justificación pedido</label>
                    <textarea class="form-control" style="height: 50px" id="justification" placeholder="Justificacion"
                              name="justification" required>{{ Session::get("justificacion") }}</textarea>
                </div>
                <div style="display: flex; justify-content: space-around; align-items: center; text-align: center;">
                    @php
                        $fechaConFormatoMin = \Carbon\Carbon::parse($closestDate->fechaMinima)->format('d-m-Y');
                        $horaConFormatoMin = \Carbon\Carbon::parse($closestDate->fechaMinima)->format('H:i');
                        $fechaConFormatoMax = \Carbon\Carbon::parse($closestDate->fechaMaxima)->format('d-m-Y');
                        $horaConFormatoMax = \Carbon\Carbon::parse($closestDate->fechaMaxima)->format('H:i');
                    @endphp
                </div><br>
                <div style="margin-top: 2%">
                    <p class="carrito-size" style="text-align: center; font-size: 22px; font-weight: bold;">Productos</p>
                </div>
            @endif
            @if(Cart::content()->count() != 0)
                <div >
                    @foreach($categorias as $categoria)
                        @php($cont = 0)
                        @foreach($cart as $productoCarrito)
                            @if($productoCarrito->options->categoria == $categoria->nombre)
                                @php($cont++)
                            @endif
                        @endforeach
                        @if($cont > 0)
                            <p class="carrito-size" style="padding-top: 20px; color: #EE9900">{{ $categoria->nombre }}</p>
                            @foreach($cart as $productoCarrito)
                                @if($productoCarrito->options->categoria == $categoria->nombre)
                                    <div class="cart-item" style="display: flex; flex-wrap: wrap; width: 95%; height: 115px">
                                        <div class="info-producto" style=" display: flex;">
                                            <span class="item-name" style="font-size: 14px">{{$productoCarrito->name}}</span>
                                            <div class="quantity-controls">
                                                <button
                                                    wire:click.prevent="restElementToProduct('{{ json_encode($productoCarrito) }}')"
                                                    class="btn minus-btn btn-carrito">
                                                    -
                                                </button>
                                                <span class="item-quantity">{{$productoCarrito->qty}} ud</span>
                                                <button
                                                    wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                                                    class="btn plus-btn btn-carrito">+
                                                </button>
                                            </div>
                                            <button
                                                wire:click.prevent="removeFromCart('{{ json_encode($productoCarrito) }}')"
                                                class="btn delete-btn">
                                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.99997 8H6.5M6.5 8V18C6.5 19.1046 7.39543 20 8.5 20H15.5C16.6046 20 17.5 19.1046 17.5 18V8M6.5 8H17.5M17.5 8H19M9 5H15M9.99997 11.5V16.5M14 11.5V16.5"
                                                        stroke="#464455" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <br><br>
                                        <div class="observacion" style="width: 100%; display: flex;">
                                            <textarea class="form-control" style="width: 100%; height: 40px"
                                                      id="observacion{{"-".$productoCarrito->rowId}}" placeholder="Observación"
                                                      name="observacion{{"-".$productoCarrito->rowId}}">{{ Session::get("observacion") }}</textarea>
                                        </div>
                                        <!--<button type="button" class="btn btn-primary btn-lg justificacion" data-bs-toggle="modal" data-bs-target="#justificacionModal">Justificación</button>-->
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <br><br>
        @if(Cart::content()->count() != 0)
            <div class="d-flex justify-content-around align-items-center" style="flex-wrap: wrap; text-align: center">
                <div class="mb-3 fecha-hora" style="width: 40%">
                    <label>Fecha prevista de pedido </label>
                    <input type="date" class="form-control" id="expectedDate" name="expectedDate"
                           pattern="\d{4}-\d{2}-\d{2}" value="{{ $expectedDate }}" required>
                </div>
                <div class="mb-3 fecha-hora" style="width: 40%">
                    <label style="margin-bottom: 2px">Hora prevista de pedido</label>
                    <input type="time" class="form-control" id="expectedTime" name="expectedTime"
                           value="{{ $expectedTime }}" required>
                </div>
            </div>
            <div style="width: 100%; text-align: center; padding: 10px">
                @if(Cart::content()->count() != 0)
                    <button style="font-size: 130%; width: 50%; padding: 10px; background: #F6C366"
                            class="btn" data-bs-toggle="modal" @if($presupuesto == null or $total == "0") data-bs-target="#presupuesto"
                            type="button" @else type="submit" @endif >
                        Hacer pedido
                    </button>
                @endif
            </div>
        @endif
    </form>
</div>

<div class="modal fade modal-lg" id="presupuesto" tabindex="-1" aria-labelledby="presupuesto" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #FAC3C3">
                <p style="font-size: 18px">No tienes presupuesto para realizar el pedido</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
