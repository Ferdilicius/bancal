<div class="bg-gray-100">

    <!-- Desktop Header -->
    <header x-data="{ open: false }"
        class="@if (Route::currentRouteName() === 'home') absolute @endif top-0 left-0 w-full bg-transparent text-white p-4 hidden md:block z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-20 md:h-28">
            </a>

            <!-- Search Bar Desktop -->
            <livewire:search-bar />

            <!-- User and Cart Icons -->
            <nav class="hidden md:flex space-x-4">

                <!-- Products Link -->
                <a href="{{ route('products.index') }}" class="ml-4">
                    <button
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(158,32,63,0.75)]">
                        <i class="fa-solid fa-box text-[#9E203F] text-3xl"></i>
                    </button>
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('shopping.cart') }}" class="ml-4">
                    <button
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(158,32,63,0.75)]">
                        <i class="fa-solid fa-cart-shopping text-[#9E203F] text-3xl"></i>
                    </button>
                </a>

                <!-- User Dropdown -->
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-[0_0_10px_rgba(158,32,63,0.75)] transition-all duration-300">
                        @auth
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                                class="w-12 h-12 rounded-full object-cover">
                        @else
                            <i class="fa-solid fa-user text-[#9E203F] text-3xl"></i>
                        @endauth
                    </button>
                    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl z-20 overflow-hidden">

                        @auth
                            <a href="{{ route('private-profile') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:bg-gray-100 hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-user-circle mr-2"></i> Mi Perfil
                            </a>
                            <a href="{{ route('profile.show') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:bg-gray-100 hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-gear mr-2"></i> Configuración
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-6 py-3 text-base text-[#9E203F] hover:bg-gray-100 hover:text-[#7A162E] transition-colors duration-200">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:bg-gray-100 hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:bg-gray-100 hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-user-plus mr-2"></i> Register
                            </a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Header -->
    <header x-data="{ open: false }"
        class=" @if (Route::currentRouteName() === 'home') absolute @endif top-0 left-0 w-full bg-transparent text-white p-4 md:hidden z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-16 w-16">
            </a>

            <!-- Search Bar Mobile -->
            <div class="flex-grow mx-4">
                <div class="relative">
                    <input type="text" placeholder="EXPLORAR BANCALES"
                        class="w-full h-7 px-4 pl-10 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-sm" />
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-[#9E203F]"></i>
                </div>
            </div>

            <!-- Mobile Menu Buttons -->
            <nav class="flex space-x-2">
                <!-- User Icon -->
                <a href="{{ route('profile.show') }}">
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user text-[#9E203F] text-xl"></i>
                    </button>
                </a>

                <!-- Cart Icon -->
                <a href="#">
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-cart-shopping text-[#9E203F] text-xl"></i>
                    </button>
                </a>
            </nav>
        </div>
    </header>
</div>
