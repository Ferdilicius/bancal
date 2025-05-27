<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" href="{{ asset('static/img/iconFresa.svg') }}" type="image/x-icon">

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous">

    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    @vite(['resources/css/app.css', 'resources/css/fonts.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="min-h-screen flex flex-col" style="font-family: 'DynaPuff_Regular', sans-serif;">

    @include('partials.header')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('partials.footer')

    @livewireScripts
</body>

</html>
