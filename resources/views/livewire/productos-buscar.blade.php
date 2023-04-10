<div>
    <div style="width: 60%; margin: auto; border: 2px solid black; border-radius: 50px; height: 50px; display: flex; justify-content: space-around; align-items: center;">
        <input wire:model="searchTerm" type="text" style="width: 80%; height: 35px; font-size: 150%; text-align: center; outline: none; border: 2px solid white;" />
        <img src="https://cdn-icons-png.flaticon.com/512/3917/3917132.png" style="height: 30px;"/>
    </div>
    <br>
    @if($productos && $productos->count() > 0)
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            @foreach($productos as $producto)
                <form wire:submit.prevent="addToCart({{$producto->id}})">
                <div class="card" style="width: 16rem; margin: 5px; height:98%;">
                    <div style="height: 50%">
                        <img src="{{ $producto->fotoUrl }}" class="card-img-top">
                    </div>
                    <div class="card-body" style="text-align: center; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; height: 50%">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <input wire:model="cantidad.{{$producto->id}}" style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                        @if(\Gloudemans\Shoppingcart\Facades\Cart::content()->where('id',$producto->id)->count())
                            <button style="width: 75%; margin: 15px; font-size: 120%" type="submit" class="btn btn-primary disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </button>
                        @else
                            <button style="width: 75%; margin: 15px; font-size: 120%" type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                </form>
            @endforeach
        </div>
    @else
        <div style="width: 60%; margin: auto">
            <div class="alert alert-danger" role="alert">
                El producto no existe
            </div>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                INSERTAR PRODUCTO
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Insertar producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route("producto.store") }}" method="post" enctype="multipart/form-data" >
                            @csrf
                            @method("POST")
                            <div class="form-group">
                                <label for="nombre" style="margin:15px 0px;">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $searchTerm }}">
                            </div>
                            <div>
                                <label for="categoria" style="margin:15px 0px;">Categoría</label>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="idCategoria">
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
                                <td><button type="submit" class="btn btn-primary">AÑADIR</button></td>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
