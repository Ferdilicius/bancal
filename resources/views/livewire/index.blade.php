@section('title', 'Bancal - Página Principal')

@vite('resources/css/index.css')

<!-- Hero -->
<div>
    <div class="relative top-0 block md:hidden">
        <video class="w-screen h-screen object-cover" autoplay muted loop>
            <source src="{{ asset('videos/hero_mobile.mp4') }}" type="video/mp4">
            Tu navegador no soporta la reproducción de vídeos.
        </video>
    </div>
<!-- Barra animada: ¿Quiénes somos? -->
<div class="bg-[#9E203F] text-white text-center py-4 overflow-hidden relative">
    <div class="animate-marquee whitespace-nowrap">
        <span class="banner">¿Qué es Bancal? ¿Qué es Bancal? </span>
    </div>
</div>

    <livewire:mostrar-todos />
</div>
