<header x-data="{ dropdownOpen: false }"
    class="@if (Route::currentRouteName() === 'home') absolute @endif top-0 left-0 w-full bg-transparent text-white p-4 z-10">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}">
            <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-16 w-16 md:h-20 md:w-auto mr-4">
        </a>

        <!-- Search Bar -->
        <div class="flex-grow mx-4">
            @if (Route::currentRouteName() === 'product.index')
                <livewire:search-bar :show-results="false" />
            @else
                <livewire:search-bar />
            @endif
        </div>

        <!-- Navigation Icons -->
        <nav class="flex space-x-2 md:space-x-4 items-center" x-data="{ mobileMenuOpen: false, mobileDropdownOpen: false }">
            <!-- Hamburger for mobile -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-lg">
                <i
                    :class="mobileMenuOpen ? 'fa-solid fa-xmark text-[#9E203F] text-xl' :
                        'fa-solid fa-bars text-[#9E203F] text-xl'"></i>
            </button>

            <!-- Desktop navigation -->
            <div class="hidden md:flex space-x-2 md:space-x-4 items-center">
                <a href="{{ route('product.index') }}">
                    <button
                        class="w-10 h-10 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(158,32,63,0.75)] transition-all duration-200 hover:bg-[#F8E7EC]">
                        <i class="fa-solid fa-box text-[#9E203F] text-xl md:text-3xl"></i>
                    </button>
                </a>
                <a href="{{ route('shopping-cart.index') }}">
                    <button
                        class="w-10 h-10 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(158,32,63,0.75)] transition-all duration-200 hover:bg-[#F8E7EC]">
                        <i class="fa-solid fa-cart-shopping text-[#9E203F] text-xl md:text-3xl"></i>
                    </button>
                </a>
                <!-- User Dropdown -->
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="w-10 h-10 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-[0_0_10px_rgba(158,32,63,0.75)] transition-all duration-300 hover:bg-[#F8E7EC]">
                        @auth
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                                class="w-8 h-8 md:w-12 md:h-12 rounded-full object-cover">
                        @else
                            <i class="fa-solid fa-user text-[#9E203F] text-xl md:text-3xl"></i>
                        @endauth
                    </button>
                    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false"
                        class="absolute right-0 mt-3 w-48 md:w-56 bg-white rounded-xl shadow-xl z-20 overflow-hidden">
                        @auth
                            <a href="{{ route('private-profile') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-user-circle mr-2"></i> Mi Perfil
                            </a>
                            <a href="{{ route('profile.show') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-gear mr-2"></i> Configuración
                            </a>
                            <a href="{{ route('contact') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-headset mr-2"></i> Soporte
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar sesión
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-user-plus mr-2"></i> Register
                            </a>
                            <a href="{{ route('contact') }}"
                                class="block px-6 py-3 text-base text-[#9E203F] hover:text-[#7A162E] hover:bg-[#F8E7EC] transition-colors duration-200">
                                <i class="fa-solid fa-headset mr-2"></i> Soporte
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Botón de admin (del archivo 1) -->
                @auth
                    @if (Auth::user()->user_type === 'admin')
                        <a href="{{ route('admin.index') }}">
                            <button
                                class="w-10 h-10 md:w-14 md:h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(158,32,63,0.75)] transition-all duration-200 hover:bg-[#F8E7EC]">
                                <i class="fa-solid fa-user-tie text-[#9E203F] text-xl md:text-3xl"></i>
                            </button>
                        </a>
                        
                    @endif
                @endauth
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-30 flex flex-col items-end md:hidden"
                @click.self="mobileMenuOpen = false" style="background: transparent;">
                <div class="bg-white w-60 h-full max-h-screen overflow-y-auto shadow-xl p-6 flex flex-col space-y-2">
                    @auth
                        <!-- Sección de cuenta -->
                        <div class="border-b border-[#F8E7EC] pb-2 mb-2">
                            <a href="{{ route('private-profile') }}"
                                class="flex items-center space-x-3 px-4 py-3 rounded text-base text-[#9E203F] hover:bg-[#F8E7EC] hover:text-[#7A162E] transition-colors duration-200">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                                    class="w-7 h-7 rounded-full object-cover border-2 border-[#9E203F]">
                                <span>Mi Perfil</span>
                            </a>
                            <a href="{{ route('profile.show') }}"
                                class="flex items-center space-x-3 px-4 py-3 rounded text-base text-[#9E203F] hover:bg-[#F8E7EC] hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-gear text-xl"></i>
                                <span>Configuración</span>
                            </a>
                            <div x-data="{ open: false }">
                                <form method="POST" action="{{ route('logout') }}" @submit.prevent="open = true">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-3 w-full text-left px-4 py-3 rounded text-base text-[#9E203F] hover:bg-[#F8E7EC] hover:text-[#7A162E] transition-colors duration-200">
                                        <i class="fa-solid fa-right-from-bracket text-xl"></i>
                                        <span>Cerrar sesión</span>
                                    </button>
                                </form>
                                <!-- Modal de confirmación -->
                                <div x-show="open" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                    <div class="bg-white rounded-xl shadow-lg p-10 max-w-sm w-full text-center"
                                        @click.away="open = false" @keydown.escape.window="open = false">
                                        <h2 class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres cerrar sesión?
                                        </h2>
                                        <p class="mb-8 text-gray-600">Tendrás que iniciar sesión de nuevo para acceder a tu
                                            cuenta.</p>
                                        <div class="flex gap-6 justify-center">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center bg-red-700 text-white px-8 py-4 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base">
                                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Sí, cerrar sesión
                                                </button>
                                            </form>
                                            <button type="button" @click="open = false"
                                                class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            class="w-full flex items-center space-x-3 py-3 rounded transition-all duration-200 hover:bg-[#F8E7EC]">
                            <i class="fa-solid fa-user text-[#9E203F] text-xl"></i>
                            <span class="text-[#9E203F] font-semibold text-base">Cuenta</span>
                        </div>
                        <!-- Sección de cuenta -->
                        <div class="border-b border-[#F8E7EC] pb-2 mb-2">
                            <a href="{{ route('login') }}"
                                class="flex items-center space-x-3 px-4 py-3 rounded text-base text-[#9E203F] hover:bg-[#F8E7EC] hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-right-to-bracket text-xl"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}"
                                class="flex items-center space-x-3 px-4 py-3 rounded text-base text-[#9E203F] hover:bg-[#F8E7EC] hover:text-[#7A162E] transition-colors duration-200">
                                <i class="fa-solid fa-user-plus text-xl"></i>
                                <span>Register</span>
                            </a>
                        </div>
                    @endauth
                    <!-- Sección de navegación -->
                    <div>
                        <a href="{{ route('product.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded transition-all duration-200 hover:bg-[#F8E7EC] hover:text-[#7A162E] ">
                            <i class="fa-solid fa-box text-[#9E203F] text-xl"></i>
                            <span class="text-[#9E203F] font-semibold text-base">Productos</span>
                        </a>
                        <a href="{{ route('shopping-cart.index') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded transition-all duration-200 hover:bg-[#F8E7EC] hover:text-[#7A162E]">
                            <i class="fa-solid fa-cart-shopping text-[#9E203F] text-xl"></i>
                            <span class="text-[#9E203F] font-semibold text-base">Carrito</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>