<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>
    @include('layouts.bancal.header')

    {{ $slot }}

    @include('layouts.bancal.footer')

    <script src="https://kit.fontawesome.com/ad6539a3b4.js" crossorigin="anonymous"></script>

    @livewireScripts
</body>

</html>
