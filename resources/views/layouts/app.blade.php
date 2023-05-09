<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SanCenando</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 450px;
            width: 100%;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .productos {
            font-size: 16px;
        }

        .pagination-mio {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .pagination-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-button {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            transition: background-color 0.3s ease;
        }

        .pagination-button:hover {
            background-color: #f5f5f5;
        }

        .pagination-button.active {
            background-color: #007bff;
            color: #fff;
        }

        #app > nav {
            background: #f6f0d2;
        }

        table.scroll thead {
            display: block;
        }

        .menu-admin {
            margin-right: 2%;
        }

        .menu-admin, .menu-admin a {
            font-size: 16px;
        }

        .nombre{
            margin-left: 1%;
        }

        .budget-container {
            background-color: #d4edda;
            border-radius: 10px;
            padding: 6px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .budget-label {
            color: #155724;
            font-size: 14px;
            font-weight: bold;
            margin-right: 6px;
        }

        .budget-amount {
            color: #155724;
            font-size: 14px;
            font-weight: bold;
        }

        .dropdown ul, .dropdown li {
            background: #f6f0d2;
        }

        .card-hover:hover {
            box-shadow: 0 0 11px rgba(33, 33, 33, .2);
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            color: #333;
            padding: 15px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }

        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
        }

        .item-name {
            font-size: 1.2rem;
            font-weight: bold;
            flex: 1;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }

        .quantity-controls .btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            padding: 0;
            cursor: pointer;
        }

        .quantity-controls .item-quantity {
            font-size: 1.2rem;
            margin: 0 1rem;
            vertical-align: middle;
        }

        .plus-btn {
            color: #61CB5F;
        }

        .minus-btn {
            color: #cc5555
        }

        @media (max-width: 768px) {
            .adm{
                margin-left: 0;
            }
            .busqueda{
                width: 90%;
            }
            .carrito{
                width: 100%;
            }
            .carrito span{
                font-size: 14px;
            }
            .busqueda-productos svg{
                width: 15px;
            }
            .cart-item{
                width: 150%;
            }
            .justificacion{
                font-size: 15px;
            }

            .cd-admin{
                width: 60%;
            }

            .cd-admin a{
                font-size: 16px;
            }

            .div-btn{
                width: 160%
            }
            .carrito-size{
                font-size: 18px;
            }
            .presupuesto{
                width: 60%;
                font-size: 12px;
            }
            .form-fecha{
                width: 100%;
            }

        }

        @media (min-width: 768px) and (max-width: 992px) {
            .cart-item{
                width: 90%;
            }
            .div-btn{
                width: 100%
            }
        }
        @media (min-width: 1024px) {
            .adm{
                margin-left: 20%;
            }
            .busqueda{
                width: 50%;
            }
            .carrito{
                width: 50%;
            }

            .carrito-cat{
                font-size: 20px;
            }
            .busqueda-productos{
                font-size: 20px;
            }

            .cd-admin{
                width: 30%;
            }

            .cd-admin a{
                font-size: 20px;
            }

            .div-btn{
                width: 160%
            }

        }

        @media (min-width: 1200px) {
            .adm{
                margin-left: 30%;
            }
            .busqueda{
                width: 60%;
            }
            .carrito{
                width: 40%;
            }
            .carrito-size{
                font-size: 22px;
            }
            .busqueda-productos{
                font-size: 20px;
            }

            .cd-admin{
                width: 30%;
            }

            .cd-admin a{
                font-size: 20px;
            }

            .div-btn{
                width: 60%
            }

            .form-fecha{
                width: 40%;
            }

        }
    </style>
    @livewireStyles
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" >
        <div class="container">
        <a class="navbar-brand m-lg-3" href="{{ url('/home') }}">
            SanCenando
        </a>
            @auth
                @if(auth()->user()->hasRole('profesor'))
                    <div class="budget-container presupuesto">
                        <span class="budget-label" style="font-size: 120%">Presupuesto:</span>
                        @if($presupuesto == null)
                            <span class="budget-amount " style="font-size: 120%">Aún no tienes presupuesto</span>
                        @else
                            <span class="budget-amount"
                                  style="font-size: 120%">{{$presupuesto->presupuestoTotal}} €</span>
                        @endif

                    </div>
                @endif
            @endauth

            @guest

            @else
                @if(auth()->user()->hasRole('admin'))
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse adm" id="navbarNavDropdown" >
                        <ul class="navbar-nav menu-admin">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                   href="{{ route('listarProfesores') }}">Profesores</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button"
                                   data-toggle="dropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Pedidos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('totalPedidos')}}">Ver pedidos</a></li>
                                    <li><a class="dropdown-item" href="{{route('fechaPedidos')}}">Fecha límite pedido</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button"
                                   data-toggle="dropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('listarProductos') }}">Ver
                                            productos</a>
                                    </li>

                                    <li><a class="dropdown-item" href="{{ route('aniadirProducto') }}">Añadir
                                            producto</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button"
                                   data-toggle="dropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Proveedores
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('listarProveedores') }}">Ver
                                            proveedores</a></li>
                                    <li><a class="dropdown-item" href="{{ route('aniadirProveedor') }}">Añadir
                                            proveedor</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endif
            @endguest

        </div>

        @auth
            <ul class="navbar-nav menu-admin nombre">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active d-flex justify-content-center align-items-center"
                       role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                             class="bi bi-person-fill" viewBox="0 0 16 16" style="margin-left: 5px; margin-right: 3px">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>
                        {{ Auth::user()->nombre . " " . Auth::user()->apellidos }}
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('misPedidos', Auth::user()->id) }}">
                                Mis pedidos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                     class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd"
                                          d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        @endauth
    </nav>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1"
         id="offcanvasWithBothOptions"
         aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"
                id="offcanvasWithBothOptionsLabel">Lista de pedidos</h5>
            <button style="display:relative" type="button" class="btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="lista" style="width: 90%; margin: 0 auto; padding: 15px;">
                @livewire('cart-list')
            </div>
        </div>
    </div>
    <main>
        @yield('content')
    </main>
</div>
@livewireScripts
</body>
</html>
