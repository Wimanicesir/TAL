<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <!-- Latest compiled and minified CSS -->
        <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
    @include('layout.header')
    <div class="social">
        <div class="social__facebook">
            <img src="{{asset('images/icons/fb.png')}}">
        </div>
        <div class="social__youtube">
            <img src="{{asset('images/icons/yt.png')}}">
        </div>
        <div class="social__pinterest">
            <img src="{{asset('images/icons/pin.png')}}">
        </div>
        <div class="social__facebook">
            <img src="{{asset('images/icons/insta.png')}}">
        </div>
    </div>
    <div class="welcome__splash">
        <div class="welcome__splash__title">
            <h2>The Animation <br> library</h2>
        </div>
        <div class="welcome__splash__button">
            <button>Explore</button>
        </div>
    </div>
    <div class="welcome__intro">
        <div class="welcome__intro__title">
            <h2>Animating has never <br> been so easy</h2>
        </div>
    </div>
    <script
            src="https://code.jquery.com/jquery-1.12.4.js"
            integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
            crossorigin="anonymous"></script>
    <script src="{{url('js/app.js')}}"></script>
    </body>
</html>
