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
    <link rel="icon" href="{{ asset("images/h.jpg") }}">
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
    @if($auth ?? '')
        <div id="auth" style="display: none"
             data-username="{{$auth['username']}}"
             data-email="{{$auth['email']}}"
             data-role="{{$auth['role']}}"
        >{{$auth['token'] ?? '1'}}</div>
        <div id="time" style="display: none">{{$mod_date ?? '1'}}</div>
    @endif
    <div id="app">
        <router-view></router-view>
    </div>

    <script src="{{ asset("js/app.js") }}"></script>
    <script>
        let auth = document.getElementById('auth');
        if (auth) {
            let time = document.getElementById('time').innerText,
                token = auth.innerText,
                username = auth.getAttribute('data-username'),
                email = auth.getAttribute('data-email'),
                role = auth.getAttribute('data-role');

            localStorage.setItem('token', token);
            localStorage.setItem('time', time);
            localStorage.setItem('username', username);
            localStorage.setItem('email', email);
            localStorage.setItem('role', role);

            window.location.href = "http://localhost:8080";
        }
    </script>
</body>
</html>
