<div>
    <h2 style="text-align: center; margin-bottom: 20px">Lista de pedido</h2>
    <div>
        @foreach($cart as $productoCarrito)
            <div
                style="display:flex; justify-content: space-between; background: #BD651D; color: white; padding: 15px; margin: 10px; border-radius: 10px ">
                <span style="font-size: 150%">{{$productoCarrito->name}}</span>
                <span style="font-size: 150%">{{$productoCarrito->qty}} ud.</span>
                @if($productoCarrito->qty == 1)
                    <!--<input type="hidden" value="{{$productoCarrito->rowId}}" name="rowId">-->
                    <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn" style="background: #61CB5F">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </button>
                    <button wire:click.prevent="removeFromCart('{{ json_encode($productoCarrito) }}')"
                            class="btn" style="background: #CB5F5F">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                @elseif($productoCarrito->qty > 1)
                    <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn" style="background: #61CB5F">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </button>
                    <button wire:click.prevent="restElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn" style="background: #CB5F5F">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </button>
                @endif

            </div>
        @endforeach
    </div>
    <div style="width: 100%; text-align: center; padding: 10px">
        <form action="{{route('cart.confirm')}}">
            @csrf
            <button type="submit" style="font-size: 130%; width: 50%; padding: 10px; background: #FF8507" class="btn">
                Hacer pedido
            </button>
        </form>
    </div>
</div>
