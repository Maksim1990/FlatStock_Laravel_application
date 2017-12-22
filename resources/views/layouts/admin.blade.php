<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($title))
        <title>{{$title}}</title>
    @else
        <title>FlatStock App</title>
    @endif

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Knewave&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{asset('css/lib/noty.css')}}" rel="stylesheet">
    <script src="{{asset('css/lib/noty.js')}}" type="text/javascript"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @yield('styles')
    @yield('scripts_header')
</head>
<body>
<div id="app">
    @include('layouts.header')
    <div id="main">
    @yield('content')
    </div>
    @include('layouts.footer')
</div>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.bx-wrapper').css('maxWidth','100%');
    });
</script>
</body>
</html>
