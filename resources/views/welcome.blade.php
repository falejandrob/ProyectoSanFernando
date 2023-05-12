<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>SanCenando</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html,
        .todo {
            background: #FFFBDA;
        }

        img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        .animated-word {
            letter-spacing: 0.25em;
            font-weight: 600;
            font-size: 50px;
            text-align: center;
            color: #C80000;
            cursor: pointer;
            outline: #C80000 solid 3px;
            transition: all 600ms cubic-bezier(0.2, 0, 0, 0.8);
            text-decoration: none;
            width: 50%;
            display: inline-block;
        }

        .animated-word-rigth {
            letter-spacing: 0.25em;
            font-weight: 600;
            font-size: 50px;
            text-align: center;
            color: #C80000;
            cursor: pointer;
            outline: #C80000 solid 3px;
            transition: all 600ms cubic-bezier(0.2, 0, 0, 0.8);
            text-decoration: none;
            width: 50%;
            display: inline-block;
        }


        .animated-word:hover, .animated-word-rigth:hover {
            color: #C80000;
            outline-color: rgba(71, 126, 232, 0);
            outline-offset: 80px;
        }

        @media (max-width: 768px) {
            img{
                width: 70%;
            }
            .div-padre{
            }
            .container-fluid{
                display: flex;
                flex-direction: column;
                flex-wrap: wrap;
                align-items: center;
                margin-bottom: 10%;
            }
            .animated-word,
            .animated-word-rigth {
                font-size: 20px;
                outline-offset: 20px;
                margin-left: 10%;
                width: 60%;
                display: block;
                margin: 0 auto;
            }
            .animated-word:hover, .animated-word-rigth:hover {
                outline-offset: 30px;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            img{
                width: 70%;
            }
            .div-padre{
            }
            .animated-word,
            .animated-word-rigth {
                font-size: 40px;
                outline-offset: 30px;
                margin-left: 1em;
                width: 70%;
                display: block;
                margin: 0 auto;
                margin-bottom: 15%;
            }
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            img{
                width: 40%;
            }
            .div-padre{
                display: flex;
                justify-content: center;
            }
            .animated-word,
            .animated-word-rigth {
                font-size: 25px;
                outline-offset: 35px;
                margin-left: 20%;
                width: 60%;
                margin-bottom: 5%;
                display: inline-block;
            }


        }

        @media (min-width: 1200px) {
            img{
                width: 40%;
            }
            .div-padre{
                display: flex;
                justify-content: center;
            }
            .animated-word,
            .animated-word-rigth {
                font-size: 35px;
                outline-offset: 35px;
                margin-left: 20%;
                width: 60%;
                display: inline-block;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
<div class="todo">
    <img src="logoSanCenando.png" alt="logo" />
    @if (Route::has('login'))
        <div class="div-padre">
            @auth
                <div class="container-fluid">
                    <a href="{{ url('/home') }}" class="animated-word">Inicio</a>
                </div>
            @else
                <div class="container-fluid">
                    <a href="{{ route('login') }}" class="animated-word">Iniciar Sesion</a>
                </div>
                <br>
                @if (Route::has('register'))
                    <div class="container-fluid">
                        <a href="{{ route('register') }}" class="animated-word-rigth">Registrarse</a>
                    </div>
                @endif
            @endauth
        </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
