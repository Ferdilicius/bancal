<footer class="bg-[#9E203F] text-white py-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
        <div class="text-left ml-4 md:ml-0">
            <h2 class="text-3xl font-bold tracking-wide mb-2">BANCAL</h2>
            <p class="text-base md:text-lg">Cultivando una gran comunidad.</p>
        </div>
        <div class="text-left ml-4 md:ml-0">
            <h3 class="font-semibold mb-2 text-lg">Contacto</h3>
            <ul class="text-base md:text-lg space-y-1">
                <li>
                    <span class="inline-block w-5"><i class="fa fa-phone"></i></span>
                    <a href="tel:968713016" class="hover:underline">968 71 30 16</a>
                </li>
                <li>
                    <span class="inline-block w-5"><i class="fa fa-envelope"></i></span>
                    <a href="mailto:info@bancal.com" class="hover:underline">soporte@bancal.com</a>
                </li>
                <li>
                    <span class="inline-block w-5"><i class="fa fa-map-marker"></i></span>
                    Calle Ejemplo, 123, 30000, Murcia
                </li>
            </ul>
        </div>
        <div class="text-left ml-4 md:ml-0">
            <h3 class="font-semibold mb-2 text-lg">Síguenos</h3>
            <div class="flex justify-start gap-3 mt-1 text-xl">
                <a href="#" aria-label="Facebook" class="hover:text-gray-200"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram" class="hover:text-gray-200"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn" class="hover:text-gray-200"><i class="fab fa-linkedin-in"></i></a>
            </div>

            <div class="w-full mt-8 border-t border-white pt-4 flex flex-col md:flex-row justify-start items-start gap-4 text-sm">
                <a href="{{ route('policy') }}" class="hover:underline">Políticas de Privacidad</a>
                <span class="hidden md:inline-block">|</span>
                <a href="{{ route('terms') }}" class="hover:underline">Términos de Uso</a>
            </div>
        </div>
    </div>
</footer>
