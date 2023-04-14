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
        nav {
            background: #f6f0d2;
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

        html {
            background: #FFFFFF;
        }

        main {
            background: #FFFFFF;
        }

        .card-hover:hover {
            box-shadow: 0 0 11px rgba(33, 33, 33, .2);
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }
    </style>
    @livewireStyles
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        @auth
            <p style="margin: 15px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                     class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                </svg>
                {{ Auth::user()->nombre . " " . Auth::user()->apellidos }}
            </p>
        @endauth

        <div class="container">
            @auth
                <div class="budget-container">
                    <span class="budget-label" style="font-size: 120%">Presupuesto:</span>
                    <span class="budget-amount" style="font-size: 120%">500 €</span>
                </div>
            @endauth

            <a class="navbar-brand" href="{{ url('/') }}">
                SanCenando
            </a>

            <div id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <ul class="navbar-nav menu-admin">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('listarProfesores') }}">Profesores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Pedidos</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-toggle="dropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('listarProductos') }}">Ver productos</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('aniadirProducto') }}">Añadir
                                            producto</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-toggle="dropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Proveedores
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Ver proveedores</a></li>
                                    <li><a class="dropdown-item" href="#">Añadir proveedor</a></li>
                                </ul>
                            </li>
                        </ul>
                        <button
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                            aria-controls="offcanvasWithBothOptions"
                            class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                 class="bi bi-cart" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                        </button>
                    @endguest
                </ul>
            </div>
        </div>

        @auth
            <a style="margin-right: 15px; background: #C80000; color: white" type="button" class="btn"
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                     class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                    <path fill-rule="evenodd"
                          d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </nav>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
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

    <main class="py-4">
        @yield('content')
    </main>
</div>
@livewireScripts
</body>
</html>
