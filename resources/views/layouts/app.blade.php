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


    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')

    @livewireStyles
</head>

<body class="min-h-screen flex flex-col" style="font-family: 'DynaPuff_Regular', sans-serif;">

    <main class="min-h-screen">

        @unless (request()->is('admin*'))
            @include('partials.header')
        @endunless

        {{ $slot }}

    </main>

    @unless (request()->is('admin*'))
        @include('partials.footer')
    @endunless

    @include('partials.accessibility')

    @yield('scripts')

    @livewireScripts
</body>

</html>
