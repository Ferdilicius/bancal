<div class="bg-gray-100">

    <!-- Desktop Header -->
    <header x-data="{ open: false }" class="bg-[#9E203F] text-white p-4 hidden md:block">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-20 md:h-28">
            </a>

            <!-- User and Cart Icons -->
            <nav class="hidden md:flex space-x-4">
                <a href="{{ route('profile.show') }}" class="mr-4">
                    <i class="fa-solid fa-user text-3xl"></i>
                </a>
                <a href="#" class="ml-4">
                    <i class="fa-solid fa-cart-shopping text-3xl"></i>
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
                    <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-16 w-16">
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <nav class="flex space-x-4 md:hidden">
                <a href="{{ route('profile.show') }}" class="mr-4">
                    <i class="fa-solid fa-user text-2xl"></i>
                </a>
                <a href="#" class="ml-4">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </a>
            </nav>
        </div>
    </header>
</div>
