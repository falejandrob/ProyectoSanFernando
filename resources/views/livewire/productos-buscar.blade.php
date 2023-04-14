<div>
    <div
        style="width: 60%; margin: auto; border: 2px solid #F6C366; border-radius: 50px; height: 50px; display: flex; justify-content: space-around; align-items: center;">
        <input wire:model="searchTerm" type="text"
               style="width: 80%; height: 35px; font-size: 150%; text-align: center; outline: none; border: 2px solid white; background: white"/>
        <img src="https://cdn-icons-png.flaticon.com/512/3917/3917132.png" style="height: 30px;"/>
    </div>
    <br>
    @if($productos && $productos->count() > 0)
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            @foreach($productos as $producto)

                <div class="card card-hover" style="width: 16rem; margin: 5px; height:400px; border: 2px solid white;">
                    <div style="height: 400px; padding: 10px">
                        <img src="{{ $producto->fotoUrl }}" class="card-img-top" style="background: #F5F6F6">
                    </div>
                    <div class="card-body"
                         style="text-align: center; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; height: 50%">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <!--<input
                            wire:model="cantidad.{{$producto->id}}"
                            style="width: 50%; margin: auto; text-align: center;border: 2px solid #F6C366; background: #FFFBDA; padding-left: 20px; padding-right: 20px;"
                            min="1"
                            value="1"
                            type="number"
                            class="form-control arrow-input"
                        />-->

                        {{--@dd($carrito->where('id',$producto->id)->first())--}}
                        @if(optional($carrito->where('id', $producto->id)->first())->qty != null)
                            @if($carrito->where('id',$producto->id)->first()->qty == 1)
                                {{--@dd($carrito->where('id',$producto->id)->first()->qty == 1)--}}
                            <br>
                                <button
                                    wire:click.prevent="removeFromCart('{{ $carrito->where('id', $producto->id)->first()->rowId }}')"
                                    class="btn" style="background: #CB5F5F">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                         class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                    </svg>
                                </button>
                                <button
                                    wire:click.prevent="addElementToProduct('{{ $carrito->where('id', $producto->id)->first()->rowId }}')"
                                    class="btn" style="background: #61CB5F">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                         class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                    </svg>
                                </button>
                            @endif
                        @endif
                        @if(optional($carrito->where('id', $producto->id)->first())->qty != null)
                            @if($carrito->where('id',$producto->id)->first()->qty > 1)
                                <button
                                    wire:click.prevent="restElementToProduct('{{ $carrito->where('id', $producto->id)->first()->rowId }}')"
                                    class="btn" style="background: #CB5F5F">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                    </svg>
                                </button>
                                <button
                                    wire:click.prevent="addElementToProduct('{{ $carrito->where('id', $producto->id)->first()->rowId }}')"
                                    class="btn" style="background: #61CB5F">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                    </svg>
                                </button>
                            @endif
                        @endif
                        @if(optional($carrito->where('id', $producto->id)->first())->qty == null)
                            <button wire:click.prevent="addToCart({{$producto->id}})"
                                    style="width: 75%; margin: 15px; font-size: 120%; background: #F6C366" type="submit"
                                    class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                     class="bi bi-cart" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>

    @else
        <div style="width: 60%; margin: auto">
            <div class="alert"
                 style="text-align: center; font-size: 120%; border: solid 2px #C80000; background: #F3D8D8">
                El producto no existe
            </div>

            <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="background: #F5BA53; width: 50%; margin-left: 25%; padding: 10px">
                INSERTAR PRODUCTO
            </button>
        </div>
        <!---->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Insertar producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route("producto.store") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("POST")
                            <div class="form-group">
                                <label for="nombre" style="margin:15px 0px;">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                       value="{{ $searchTerm }}">
                            </div>
                            <div>
                                <label for="categoria" style="margin:15px 0px;">Categoría</label>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        name="idCategoria">
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <p>
                                    Sube una imagen:<br><br>
                                    <input type="file" name="foto" accept="image/png, .jpeg, .jpg, image/gif">
                                </p>
                            </div>
                            <hr/>
                            <div class="form-group" style="text-align: right">
                                <td>
                                    <button type="submit" class="btn btn-primary">AÑADIR</button>
                                </td>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
