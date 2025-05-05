<div class="bg-gray-100">
    <header class="bg-[#9E203F] text-white p-4 hidden md:block">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo de la fresa -->
            <a href="{{ url('/') }}">
                <img src="ruta/a/la/fresa.png" alt="Bancal" class="h-10 md:h-14">
            </a>

            <!-- Botón menú móvil -->
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Íconos de usuario y carrito en escritorio -->
            <nav class="hidden md:flex space-x-4">
                <a href="pagina_usuario_placeholder.html">
                    <img src="ruta/a/icono_usuario.png" alt="Usuario" class="h-8">
                </a>
                <a href="pagina_carrito.html">
                    <img src="ruta/a/icono_carrito.png" alt="Carrito" class="h-8">
                </a>
            </nav>
        </div>

        <!-- Menú desplegable en móviles -->
        <div x-show="open" class="md:hidden bg-gray-100 mt-2 p-4">
            <a href="pagina_usuario.html" class="block py-2 hover:bg-gray-200">Usuario</a>
            <a href="pagina_carrito.html" class="block py-2 hover:bg-gray-200">Carrito</a>
        </div>
    </header>

    <header class="bg-red-600 text-white p-4 rounded-b-3xl md:hidden">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex-1 flex justify-center">
                <!-- Logo centrado -->
                <a href="{{ url('/') }}">
                    <img src="ruta/a/la/fresa.png" alt="Bancal" class="h-16">
                </a>
            </div>
        </div>
    </header>
</div>
