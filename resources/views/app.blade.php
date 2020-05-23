<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Market</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("css/all.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Josefin Sans', sans-serif;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    @if($token ?? '')
        <div id="token" style="display: none">{{$token ?? '1'}}</div>
        <div id="time" style="display: none">{{$mod_date ?? '1'}}</div>
    @endif
    <div id="app">
        <router-view></router-view>
    </div>

    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        if (document.getElementById('token')) {
            let token = document.getElementById('token').innerText;
            let time = document.getElementById('time').innerText;
            localStorage.setItem('token', token);
            localStorage.setItem('time', time);
            window.location.href = "http://localhost:8000";
        }
    </script>
</body>
</html>
