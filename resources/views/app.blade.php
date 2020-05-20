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
    <div id="app">
        <nav>
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        </nav>
        <router-view></router-view>
    </div>

    <script src="{{ asset("js/app.js") }}"></script>
</body>
</html>
