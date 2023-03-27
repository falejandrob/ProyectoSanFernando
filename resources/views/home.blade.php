@extends('layouts.app')

@section('content')
<div style="display: flex; width: 90%; margin:auto;">
    <div class="lista" style="width: 30%; padding: 15px">
        <h2 style="text-align: center; margin-bottom: 20px">Lista de pedido</h2>
        <div>
            <div style="display:flex; justify-content: space-between; background: #4b5563; color: white; padding: 15px; margin: 10px">
                <span style="font-size: 150%">Patatas - 3kg</span>
                <button type="button" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                    </svg>
                </button>
            </div>
            <div style="display:flex; justify-content: space-between; background: #4b5563; color: white; padding: 15px; margin: 10px">
                <span style="font-size: 150%">Patatas - 3kg</span>
                <button type="button" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                    </svg>
                </button>
            </div>
            <div style="display:flex; justify-content: space-between; background: #4b5563; color: white; padding: 15px; margin: 10px">
                <span style="font-size: 150%">Patatas - 3kg</span>
                <button type="button" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                    </svg>
                </button>
            </div>
        </div>
        <div style="width: 100%; text-align: center; padding: 10px">
            <button style="font-size: 130%; width: 50%; padding: 10px" type="button" class="btn btn-success">Hacer pedido</button>
        </div>
    </div>

    <div class="productos" style="width: 70%; padding: 15px">
        <div style="width: 60%; margin: auto;">
            <input type="text" class="rounded-pill" style="width: 100%; height: 50px; font-size: 150%; text-align: center;">
        </div>
        <br/>
        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://www.frutas-hortalizas.com/img/fruites_verdures/presentacio/59.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de patatas</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://nomen.es/wp-content/uploads/2021/03/nomen-harina-trigo-reposteria.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de harina</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://nomen.es/wp-content/uploads/2021/03/nomen-harina-trigo-reposteria.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de harina</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://nomen.es/wp-content/uploads/2021/03/nomen-harina-trigo-reposteria.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de harina</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://nomen.es/wp-content/uploads/2021/03/nomen-harina-trigo-reposteria.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de harina</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div style="width: 20%; height: 350px; background: #9ca3af; padding: 15px; margin: 5px">
                <div style="text-align: center">
                    <img style="max-width: 100%; width: auto; max-height: 160px; height: auto;" src="https://nomen.es/wp-content/uploads/2021/03/nomen-harina-trigo-reposteria.jpg"/>
                </div>
                <div style="text-align: center; padding: 10px">
                    <h5 style="margin: 15px">Kilo de harina</h5>
                    <input style="width: 50%; margin: auto; text-align: center" min="1" value="1" type="number" class="form-control">
                    <button style="width: 75%; margin: 15px; font-size: 120%" type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
