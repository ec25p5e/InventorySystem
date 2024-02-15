<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/icon-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}"/>
</head>
<body class="hold-transition login-page">

    @yield('login')

    <script src="{{ asset('template/scripts/core.js') }} "></script>
    <script src="{{ asset('template/scripts/script.js') }} "></script>
    <script src="{{ asset('template/scripts/process.js') }} "></script>
    <script src="{{ asset('template/scripts/layout-settings.js') }} "></script>
</body>
</html>
