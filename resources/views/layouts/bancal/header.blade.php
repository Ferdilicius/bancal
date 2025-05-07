<div class="bg-gray-100">

    <!-- Desktop Header -->
    <header x-data="{ open: false }" class="absolute top-0 left-0 w-full bg-transparent text-white p-4 hidden md:block z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}">
            <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal" class="h-20 md:h-28">
            </a>

            <!-- Search Bar Desktop -->
            <div class="flex-grow mx-4 flex justify-center">
            <div class="relative w-3/4">
                <input 
                type="text" 
                placeholder="EXPLORAR BANCALES" 
                class="w-full h-10 px-4 pl-10 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] placeholder:mb-[3px] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-base"
                />
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-[#9E203F]"></i>
            </div>
            </div>

            <!-- User and Cart Icons -->
            <nav class="hidden md:flex space-x-2">
            <a href="{{ route('profile.show') }}" class="mr-4">
                <button class="w-14 h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[inset_0_0_10px_rgba(0,0,0,0.75)]">
                <i class="fa-solid fa-user text-[#9E203F] text-3xl"></i>
                </button>
            </a>
            <a href="#" class="ml-4">
                <button class="w-14 h-14 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_10px_rgba(0,0,0,0.75)]">
                <i class="fa-solid fa-cart-shopping text-[#9E203F] text-3xl"></i>
                </button>
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

            <!-- Search Bar Mobile -->
            <div class="flex-grow mx-4">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="EXPLORAR BANCALES" 
                        class="w-full h-7 px-4 pl-10 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] placeholder:mb-[3px] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-sm"
                    />
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-[#9E203F]"></i>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <nav class="flex space-x-2 md:hidden">
                <a href="{{ route('profile.show') }}" class="mr-2">
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:shadow-[inset_0_0_8px_rgba(0,0,0,0.75)]">
                        <i class="fa-solid fa-user text-[#9E203F] text-xl"></i>
                    </button>
                </a>
                <a href="#" class="ml-2">
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:shadow-[0_0_8px_rgba(0,0,0,0.75)]">
                        <i class="fa-solid fa-cart-shopping text-[#9E203F] text-xl"></i>
                    </button>
                </a>
            </nav>
        </div>
    </header>
</div>
