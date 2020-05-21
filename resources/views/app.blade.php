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
        <div id="token" style="display: none">{{$token ?? ''}}</div>
    @endif
    <div id="app">
        <nav>
            <router-link v-if="!auth" to="/login">Login</router-link>
            <router-link v-if="!auth" to="/register">Register</router-link>
            <a v-if="auth" href="logout" @click.prevent="logout">Logout</a>
        </nav>
        <router-view></router-view>
    </div>

    <script src="{{ asset("js/app.js") }}"></script>
    <script>
        let token = document.getElementById('token').innerText;
        if (token) {
            console.log('login');
            localStorage.setItem('token', token);
            window.location.href = "http://localhost:8000";
        }
    </script>
</body>
</html>
