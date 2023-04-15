<div>
    <div>
        <button wire:click.prevent="clearCart()" class="btn btn-danger">
            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.99997 8H6.5M6.5 8V18C6.5 19.1046 7.39543 20 8.5 20H15.5C16.6046 20 17.5 19.1046 17.5 18V8M6.5 8H17.5M17.5 8H19M9 5H15M9.99997 11.5V16.5M14 11.5V16.5"
                    stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Limpiar Carrito
        </button>
        <br>
        @foreach($cart as $productoCarrito)
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
            </div>
        @endforeach
    </div>
    <div style="width: 100%; text-align: center; padding: 10px">
        @if(Cart::content()->count() == 0)
            <button type="submit" style="font-size: 130%; width: 50%; padding: 10px; background: #FF8507"
                    class="btn disabled">
                Hacer pedido
            </button>
        @else
            <button type="submit" style="font-size: 130%; width: 50%; padding: 10px; background: #FF8507"
                    class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Hacer pedido
            </button>
        @endif
    </div>
    <!---->

    <div class="modal fade" id="exampleModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Insertar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('cart.confirm')}}" method="post">
                        @csrf
                        @method("POST")
                        <div class="form-row">
                            <div class="mb-3">
                                <label>Para cuando se quiere el pedido</label>
                                <input type="date" class="form-control" id="expectedDate" name="expectedDate" required pattern="\d{4}-\d{2}-\d{2}" required>
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
</div>
