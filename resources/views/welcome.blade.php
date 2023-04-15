<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>SanCenando</title>
    <style>
        html, .todo{
            background: #FFFBDA;
        }

        img {
            width: 25%;
            margin-left: 37%;
        }

        .animated-word {
            letter-spacing: 0.25em;
            font-weight: 600;
            font-size: 50px;
            text-align: center;
            color: #C80000;
            cursor: pointer;
            outline: #C80000 solid 3px;
            outline-offset: 35px;
            transition: all 600ms cubic-bezier(0.2, 0, 0, 0.8);
            text-decoration:none;
            margin-left: 25%;
            width: 50%;
        }

        .animated-word:hover {
            color: #C80000;
            outline-color: rgba(71, 126, 232, 0);
            outline-offset: 80px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
<div class="todo">
    <img src="logoSanCenando.png" alt="logo"/>
    @if (Route::has('login'))
        <div class="d-flex justify-content-center" style="width: 70%; margin: auto">
            @auth
                <div class="container" style="margin-left: 22.5%">
                    <a href="{{ url('/home') }}" class="animated-word">Home</a>
                </div>
            @else
                <div class="container">
                    <a href="{{ route('login') }}" class="animated-word">Log in</a>
                </div>
                <br>
                @if (Route::has('register'))
                    <div class="container">
                        <a href="{{ route('register') }}" class="animated-word">Register</a>
                    </div>
                @endif
            @endauth
        </div>
    @endif
</div>
</body>
</html>
