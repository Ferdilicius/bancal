@section('title', 'Bancal - Página Principal')

@vite('resources/css/index.css')

<!-- Hero Section -->
<x-app-layout>
    <div>
        <!-- Mobile Hero Video -->
        <div class="relative top-0 block md:hidden">
            <video class="w-screen h-screen object-cover" autoplay muted loop>
                <source src="{{ asset('videos/hero_mobile.mp4') }}" type="video/mp4">
                Tu navegador no soporta la reproducción de vídeos.
            </video>
        </div>

        <!-- Desktop Hero Image -->
        <div class="relative top-0 hidden md:block">
            <video class="w-screen h-screen object-cover" autoplay muted loop>
                <source src="{{ asset('videos/hero_desktop.mp4') }}" type="video/mp4">
                Tu navegador no soporta la reproducción de vídeos.
            </video>
            {{-- <img src="{{ asset('static/img/hero_desktop.jpg') }}" alt="Hero Image" class="w-screen object-cover"> --}}
        </div>

        <!-- Animated Banner: ¿Quiénes somos? -->
        <div class="bg-red-800 text-white text-center py-6 relative overflow-hidden">
            <div class="relative overflow-hidden">
                <div class="whitespace-nowrap flex animate-scroll gap-12">
                    @foreach (range(1, 10) as $i)
                        <span class="text-2xl font-bold tracking-wider">¿Qué es Bancal?</span>
                        <span class="text-2xl font-bold tracking-wider">Un puente entre agricultores y
                            consumidores</span>
                        <span class="text-2xl font-bold tracking-wider">Cultivando conexiones únicas</span>
                        <span class="text-2xl font-bold tracking-wider">Consumo responsable y sostenible</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section: ¿Quiénes somos? -->
        <div class="bg-gray-50 text-gray-900 p-8 lg:max-w-5xl lg:mx-auto rounded-lg shadow-md my-6">
            <h2 class="text-3xl font-extrabold text-center text-[#9E203F] mb-6">¿Quiénes somos?</h2>
            <p class="text-lg leading-relaxed mb-6">
                El proyecto <span class="text-[#9E203F] font-semibold">Bancal</span> es un espacio donde la naturaleza y
                la comunidad se unen para crear algo único. Aquí, cultivamos más que alimentos: cultivamos conexiones y
                construimos un puente que acerca agricultores y consumidores, dando un hogar a productos que no
                encuentran su lugar en una estantería.
            </p>

            <p class="text-lg leading-relaxed mb-6">
                Creemos en la importancia de trabajar juntos para construir un futuro sostenible, respetando el medio
                ambiente y fomentando la colaboración entre las personas. En <span
                    class="text-[#9E203F] font-semibold">Bancal</span>, apostamos por un consumo responsable, donde cada
                compra no solo ahorra dinero, sino que también reduce el impacto ambiental y apoya a los productores
                locales.
            </p>

            <p class="text-lg leading-relaxed">
                Para conocer más sobre el proyecto, haz clic <a href="#"
                    class="text-[#9E203F] font-semibold underline hover:text-[#7c1a32] transition-colors">aquí</a>.
            </p>

            <div class="flex justify-end mt-6">
                <i
                    class="fa-solid fa-seedling text-6xl bg-gradient-to-b from-[#a9213f] to-[#5a1706] bg-clip-text text-transparent"></i>
            </div>

            <!-- Button to Products -->
            <div class="text-center mt-8">
                <a href="{{ route('products') }}"
                    class="bg-[#9E203F] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#7c1a32] transition-colors">
                    Ver Productos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
