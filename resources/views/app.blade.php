<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Test Talently</title>
</head>

<body>
    <main id="app">
        <div>
            <router-view></router-view>
        </div>
    </main>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
