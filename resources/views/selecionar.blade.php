<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="offset-2 col-8" style="top: 100px;">
                    <div class="card w-100">
                        <img id="imagem" src="{{ asset($imagem) }}" class="card-img-top" alt="Imagem enviada pelo usuário">
                        <div class="card-body">
                            <h5 class="card-title">Clique na foto para selecionar uma área</h5>
                            <p class="card-text">A posição selecionada é:</p>
                            <form action="{{ route('analisar') }}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="posicaoX">X:</label>
                                    <input id="posicaoX" type="text" class="form-control" name="posicaoX">
                                    <label for="posicaoY">Y:</label>
                                    <input id="posicaoY" type="text" class="form-control" name="posicaoY">
                                </div>
                                <button class="btn btn-primary">Analisar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $("#imagem").click(function (mouseEvent) {
        var obj = this;
        var obj_left = 0;
        var obj_top = 0;
        var xpos;
        var ypos;
        while (obj.offsetParent){
            obj_left += obj.offsetLeft;
            obj_top += obj.offsetTop;
            obj = obj.offsetParent;
        }
        if (mouseEvent){
            //FireFox
            xpos = mouseEvent.pageX;
            ypos = mouseEvent.pageY;
        }
        else {
            //IE
            xpos = window.event.x + document.body.scrollLeft - 2;
            ypos = window.event.y + document.body.scrollTop - 2;
        }
        xpos -= obj_left;
        ypos -= obj_top;

        $('#posicaoX').val(xpos);
        $('#posicaoY').val(ypos);
    });
</script>
</html>
