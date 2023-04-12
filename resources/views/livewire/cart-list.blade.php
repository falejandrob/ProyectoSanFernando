<div>
    <h2 style="text-align: center; margin-bottom: 20px">Lista de pedido</h2>
    <div>
        <!--<div style="display:flex; justify-content: space-between; background: #4b5563; color: white; padding: 15px; margin: 10px">
            <span style="font-size: 150%">Patatas - 3kg</span>
            <button type="button" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                </svg>
            </button>
        </div>-->
        <!--<form action="{{route('cart.store')}}" method="post">
                @csrf
        @method('POST')
        <input type="number" value="1"  name="quantity" class="text-sm-center">
        <button type="submit" class="btn btn-primary">Add to cart</button>
    </form>-->


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
                            class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-trash3" viewBox="3 3 26 26">
                            <path
                                d="M16 0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.032c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032zM23 15h-6v-6c0-0.552-0.448-1-1-1s-1 0.448-1 1v6h-6c-0.552 0-1 0.448-1 1s0.448 1 1 1h6v6c0 0.552 0.448 1 1 1s1-0.448 1-1v-6h6c0.552 0 1-0.448 1-1s-0.448-1-1-1z"></path>
                        </svg>
                    </button>
                @elseif($productoCarrito->qty > 1)
                    <button wire:click.prevent="restElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-trash3" viewBox="3 3 26 26">
                            <path
                                d="M16 2.672c-7.362 0-13.328 5.966-13.328 13.328s5.966 13.328 13.328 13.328c7.362 0 13.328-5.966 13.328-13.328s-5.966-13.328-13.328-13.328zM16 28.262c-6.761 0-12.262-5.501-12.262-12.262s5.501-12.262 12.262-12.262c6.761 0 12.262 5.501 12.262 12.262s-5.501 12.262-12.262 12.262z"/>
                            <path d="M9.105 15.467h13.826v1.066h-13.826v-1.066z"/>
                        </svg>
                    </button>
                    <button wire:click.prevent="addElementToProduct('{{ json_encode($productoCarrito) }}')"
                            class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-trash3" viewBox="3 3 26 26">
                            <path
                                d="M16 0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.032c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032zM23 15h-6v-6c0-0.552-0.448-1-1-1s-1 0.448-1 1v6h-6c-0.552 0-1 0.448-1 1s0.448 1 1 1h6v6c0 0.552 0.448 1 1 1s1-0.448 1-1v-6h6c0.552 0 1-0.448 1-1s-0.448-1-1-1z"></path>
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
