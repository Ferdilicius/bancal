<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>
    @include('layouts.bancal.header')

    <main>
        {{ $slot }}
    </main>

    @include('layouts.bancal.footer')

    <script src="https://kit.fontawesome.com/ad6539a3b4.js" crossorigin="anonymous"></script>

    @livewireScripts
</body>

</html>
