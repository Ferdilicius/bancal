@section('title', 'Bancal - Página Principal')

<div>
<div class="block sm:hidden">
    <video class="w-full w-screen h-screen object-cover" autoplay muted loop>
        <source src="{{ asset('videos/hero_mobile.mp4') }}" type="video/mp4">
        Tu navegador no soporta la reproducción de vídeos.
    </video>
</div>

<!-- Barra animada -->
<div class="block sm:hidden bg-salmon text-white text-center py-4 overflow-hidden relative">
    <div class="animate-marquee whitespace-nowrap">
        <span class="text-lg font-bold">¡Bienvenido a Bancal! Disfruta de nuestra plataforma. </span>
    </div>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }
            50% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
    
        .animate-marquee {
            display: inline-block;
            animation: marquee 10s linear infinite;
        }
    
        .bg-salmon {
            background-color: #FA8072; /* Color salmón */
        }
    </style>
</div>


