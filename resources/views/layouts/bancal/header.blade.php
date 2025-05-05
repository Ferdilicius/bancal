<div class="bg-gray-100">

    <!-- Desktop Header -->
    <header x-data="{ open: false }" class="bg-[#9E203F] text-white p-4 hidden md:block">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/iconFresa.svg') }}" alt="Bancal" class="h-24 md:h-28">
            </a>

            <!-- User and Cart Icons -->
            <nav class="hidden md:flex space-x-4">
                <a href="{{ route('profile.show') }}">
                    <img src="{{ asset('images/icono_usuario.png') }}" alt="Usuario" class="h-8">
                </a>
                <a href="">
                    <img src="{{ asset('images/icono_carrito.png') }}" alt="Carrito" class="h-8">
                </a>
            </nav>
        </div>
    </header>

    <!-- Mobile Header -->
    <header x-data="{ open: false }" class="absolute top-0 left-0 w-full bg-transparent text-white p-4 md:hidden z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div>
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/iconFresa.svg') }}" alt="Bancal" class="h-24 w-24">
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div>
                <button @click="open = !open" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <!-- Mobile Dropdown Menu -->
            <div x-show="open" x-cloak @click.away="open = false"
                class="bg-gray-300 bg-opacity-50 text-[#9E203F] p-4 absolute top-full left-0 w-full">
                <a href="{{ route('profile.show') }}" class="block py-2 font-bold hover:bg-gray-200 hover:bg-opacity-50">Usuario</a>
                <a href="" class="block py-2 font-bold hover:bg-gray-200 hover:bg-opacity-50">Carrito</a>
            </div>
        </div>
    </header>
</div>
