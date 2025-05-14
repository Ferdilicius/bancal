<footer class="bg-[#9E203F] text-white py-4">
    <div class="container mx-auto text-center">
        <p class="text-sm md:text-base" aria-label="Copyright">
            &copy; {{ now()->year }} <span class="font-semibold">Bancal</span>. Todos los derechos reservados.
        </p>
        <nav aria-label="Footer Navigation" class="mt-4">
            <a href="{{ route('contact') }}"
                class="inline-block text-sm md:text-base text-white underline hover:text-gray-200 focus:outline focus:outline-2 focus:outline-white">
                Contáctanos
            </a>
        </nav>
    </div>
</footer>
