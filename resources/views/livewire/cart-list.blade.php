<div>
    <h2 style="text-align: center; margin-bottom: 20px">Lista de pedidos</h2>
    <div>
        @foreach($cart as $productoCarrito)
            <div
                style="display:flex; justify-content: space-between; background: #4b5563; color: white; padding: 15px; margin: 10px; border-radius: 10px ">
                <span style="font-size: 150%">{{$productoCarrito->name}}</span>
                <span style="font-size: 150%">{{$productoCarrito->qty}} unidades</span>
                @if($productoCarrito->qty == 1)
                    <!--<input type="hidden" value="{{$productoCarrito->rowId}}" name="rowId">-->
                    <button wire:click.prevent="removeFromCart('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-trash3" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                        </svg>
                    </button>
                    <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </button>
                @elseif($productoCarrito->qty > 1)
                    <button wire:click.prevent="restElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </button>
                    <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </button>
                @endif

            </div>
        @endforeach
    </div>
    <div style="width: 100%; text-align: center; padding: 10px">
        <form action="{{route('cart.confirm')}}">
            @csrf
            <button type="submit" style="font-size: 130%; width: 50%; padding: 10px" type="button"
                    class="btn btn-success">Hacer pedido
            </button>
        </form>
    </div>
</div>
