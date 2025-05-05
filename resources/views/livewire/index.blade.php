@section('title', 'Bancal - Página Principal')

<!-- Hero Section -->
<div>
    <div class="relative top-0 block md:hidden">
        <video class="w-screen h-screen object-cover" autoplay muted loop>
            <source src="{{ asset('videos/hero_mobile.mp4') }}" type="video/mp4">
            Tu navegador no soporta la reproducción de vídeos.
        </video>
    </div>
    <livewire:mostrar-todos />
</div>
