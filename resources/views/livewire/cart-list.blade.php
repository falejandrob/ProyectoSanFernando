<div style="width: 90%; margin: auto">
    <div>
        @if(Cart::content()->count() != 0)
            <div class="d-flex justify-content-end align-items-center">
                <button wire:click.prevent="clearCart()" class="btn btn-danger d-flex justify-content-between align-items-end">
                    <span style="padding: 5px">Limpiar Carrito</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg>
                </button>
            </div>
        @endif
        <br>
        <div>
        @foreach($categorias as $categoria)
            @php($cont = 0)
            @foreach($cart as $productoCarrito)
                @if($productoCarrito->options->categoria == $categoria->nombre)
                    @php($cont++)
                @endif
            @endforeach
            @if($cont > 0)
                <h3 style="padding-top: 20px">{{ $categoria->nombre }}</h3>
                @foreach($cart as $productoCarrito)
                    @if($productoCarrito->options->categoria == $categoria->nombre)
                        <div class="cart-item">
                            <span class="item-name">{{$productoCarrito->name}}</span>
                            <div class="quantity-controls">
                                <button wire:click.prevent="restElementToProduct('{{ json_encode($productoCarrito) }}')"
                                        class="btn minus-btn">
                                    -
                                </button>
                                <span class="item-quantity">{{$productoCarrito->qty}} ud</span>
                                <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                                        class="btn plus-btn">+
                                </button>
                            </div>
                            <button wire:click.prevent="removeFromCart('{{ json_encode($productoCarrito) }}')"
                                    class="btn delete-btn">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.99997 8H6.5M6.5 8V18C6.5 19.1046 7.39543 20 8.5 20H15.5C16.6046 20 17.5 19.1046 17.5 18V8M6.5 8H17.5M17.5 8H19M9 5H15M9.99997 11.5V16.5M14 11.5V16.5"
                                        stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#justificacionModal">Justificación</button>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
        </div>
    </div>
    <div style="width: 100%; text-align: center; padding: 10px">
        @if(Cart::content()->count() != 0)
            <button type="submit" style="font-size: 130%; width: 50%; padding: 10px; background: #FF8507"
                    class="btn" data-bs-toggle="modal" data-bs-target="#confirmarPedido">
                Hacer pedido
            </button>
        @endif
    </div>
</div>
