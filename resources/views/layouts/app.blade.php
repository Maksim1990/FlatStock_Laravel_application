<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Knewave&amp;subset=latin-ext" rel="stylesheet">
    @if(isset($title))
        <title>{{$title}}</title>
    @else
        <title>FlatStock App</title>
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #header_left{
            background-color:rgba(255, 255, 255, 0.3);
            height: 90px;
            padding-top: 20px;
        }
        #header_left a{
            color: black;
            font-family: 'Knewave', cursive;
            font-size: 30px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app">
        <div class="row">
            <div class=" col-xs-12 col-sm-12  col-md-12 w3-center" id="header_left">
            <div class=" col-xs-12 col-sm-4  col-md-4 w3-center" >
                <a href="{{URL::to('/')}}">FlatsStock App</a>
            </div>
            </div>
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
