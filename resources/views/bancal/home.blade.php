@section('title', 'Bancal - Página Principal')

<!-- Hero Section -->
<x-app-layout>
    <div>
        <!-- Mobile Hero Video -->
        <div class="relative top-0 block md:hidden">
            <video class="w-screen h-screen object-cover" autoplay muted loop>
                <source src="{{ asset('static/videos/hero_mobile.mp4') }}" type="video/mp4" />
                Tu navegador no soporta la reproducción de vídeos.
            </video>
        </div>

        <!-- Desktop Hero Image -->
        <div class="relative top-0 hidden md:block">
            <video class="w-screen h-screen object-cover" autoplay muted loop>
                <source src="{{ asset('static/videos/hero_desktop.mp4') }}" type="video/mp4">
                Tu navegador no soporta la reproducción de vídeos.
            </video>
        </div>

        <!-- Animated Banner: ¿Qué es Bancal? -->
        <div class="bg-red-800 text-white text-center py-8 relative overflow-hidden"
             x-data="{
            messages: [
            '¿Qué es Bancal?',
            'Un puente entre agricultores y consumidores',
            'Cultivando conexiones únicas',
            'Consumo responsable y sostenible'
            ],
            clones: 2 // Number of times to repeat messages for seamless scroll
             }">
            <div class="relative overflow-hidden">
            <div class="flex gap-16"
             x-init="
            $nextTick(() => {
            const el = $el;
            let scrollAmount = 0;
            const scrollWidth = el.scrollWidth / (clones + 1);
            function scroll() {
            scrollAmount += 4;
            if (scrollAmount >= scrollWidth) {
            scrollAmount = 0;
            }
            el.scrollLeft = scrollAmount;
            requestAnimationFrame(scroll);
            }
            scroll();
            });
             "
             style="white-space: nowrap; overflow-x: hidden;">
            <template x-for="i in clones + 1" :key="i">
            <template x-for="msg in messages" :key="msg + i">
            <span class="text-4xl font-extrabold tracking-wider mx-10" x-text="msg"></span>
            </template>
            </template>
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
                <a href="{{ route('product.index') }}"
                    class="bg-[#9E203F] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#7c1a32] transition-colors">
                    Ver Productos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
