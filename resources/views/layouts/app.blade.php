<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DTSENA | Plataforma de monitoreo</title>
    <link rel="shortcut icon" href="{{asset('img/logo_sena.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

    

    @yield('nav')
    <div class="main">
        @yield('content')
    </div>
    @yield('footer')


</body>
</html>
