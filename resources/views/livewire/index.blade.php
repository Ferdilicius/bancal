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

    <div class="relative top-0 hidden md:block">
        <img src="{{ asset('static/img/hero_desktop.jpg') }}" alt="Hero Image" class="w-screen object-cover">
        
    </div>

<!-- Barra animada: ¿Quiénes somos? -->
<div class="bg-[#9E203F] text-white text-center py-4 overflow-hidden relative">
    <div class="animate-marquee whitespace-nowrap">
        <span class="banner">¿qué es bancal?  ¿qué es bancal?</span>
    </div>

<!-- Sección: ¿Quiénes somos? -->
</div>
    <div class="bg-white text-left p-6 lg:max-w-4xl lg:mx-auto shadow-lg">
        <p class="text-gray-800 mt-4">
            El proyecto <span class="text-[#9E203F] text_1">bancal</span> es un espacio que nace donde la naturaleza y la comunidad se encuentran para crear algo único. Aquí, cultivamos más que alimentos: cultivamos conexiones y un puente que acerca agricultores y consumidores para encontrar un hogar a todos aquellos productos que no logran su sitio en una estantería.</p>

        <p class="text-gray-800 mt-4">
            Creemos en la importancia de trabajar juntos para construir un futuro sostenible, respetando el medio ambiente y fomentando la colaboración entre las personas. En <span class="text-[#9E203F] text_1">bancal</span> apostamos por un consumo responsable, donde cada compra no solo ahorra dinero, sino que también reduce el impacto ambiental y apoya a los productores locales. </p>

            <p class="text-gray-800 mt-4">
            Para conocer más el proyecto, clica <span class="text-[#9E203F] text_1">aquí</span>. </p>
        <div class="flex justify-end mt-3 pr-7">
            <i class="fa-solid fa-seedling text-7xl" style="background: linear-gradient(to bottom, #a9213f, #5a1706); -webkit-background-clip: text; color: transparent;"></i> 
        </div>
    </div>

    <livewire:mostrar-todos />
</div>
