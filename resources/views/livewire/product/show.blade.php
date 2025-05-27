@section('title', "$product->name - Product Details")

<div class="max-w-3xl mx-auto py-12 px-4 sm:px-8">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-8 border-b border-gray-200 pb-4">Detalles del
            Producto</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-6 text-base text-gray-700">
                <div>
                    <span class="font-semibold text-gray-800">Nombre:</span>
                    <span class="ml-2">{{ $product->name }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Descripción:</span>
                    <span class="ml-2">{{ $product->description ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Cantidad:</span>
                    <span class="ml-2">{{ $product->quantity }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Precio:</span>
                    <span class="ml-2 text-green-600 font-bold">{{ number_format($product->price, 2) }} €</span>
                </div>

            </div>
            <div class="flex flex-col items-center justify-center w-full max-w-xs relative group"
                x-data="{
                    images: @js($product->images->pluck('path')),
                    current: 0,
                    prev: 0,
                    direction: 'right',
                    get hasImages() { return this.images.length > 0 },
                    get imageUrl() { return this.hasImages ? '{{ asset('storage') }}/' + this.images[this.current] : '' }
                }" x-effect="direction = current > prev ? 'right' : 'left'; prev = current">
                <div x-show="hasImages" class="relative h-40 w-full overflow-hidden">
                    <template x-for="(img, idx) in images" :key="img">
                        <img x-show="current === idx" :src="'{{ asset('storage') }}/' + img"
                            alt="Imagen del producto"
                            class="w-full h-40 object-cover absolute inset-0 rounded-lg shadow transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
                            :class="{
                                'opacity-0 -translate-x-6 scale-95': current !== idx && direction === 'right',
                                'opacity-0 translate-x-6 scale-95': current !== idx && direction === 'left',
                                'opacity-100 translate-x-0 scale-100': current === idx
                            }">
                    </template>
                    <!-- Zona izquierda invisible para ir a la imagen anterior -->
                    <button type="button"
                        class="absolute left-0 top-0 h-full w-1/2 bg-transparent cursor-pointer focus:outline-none"
                        x-show="current > 0" @click="current--; direction = 'left'" aria-label="Anterior"
                        style="display: none;">
                    </button>
                    <!-- Zona derecha invisible para ir a la imagen siguiente -->
                    <button type="button"
                        class="absolute right-0 top-0 h-full w-1/2 bg-transparent cursor-pointer focus:outline-none"
                        x-show="current < images.length - 1" @click="current++; direction = 'right'"
                        aria-label="Siguiente" style="display: none;">
                    </button>
                </div>
                <div x-show="!hasImages" class="flex items-center justify-center w-full h-32 bg-gray-100 rounded-lg border border-gray-200 shadow-sm text-gray-500 text-sm font-semibold">
                    Sin imagen
                </div>
            </div>
        </div>
        <div class="mt-10 flex flex-col sm:flex-row gap-4 items-center">
            <a href="#"
                class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                <i class="fas fa-shopping-bag"></i>
                <span>Comprar</span>
            </a>
            <a href="#"
                class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                <i class="fas fa-cart-plus"></i>
                <span>Añadir al Carrito</span>
            </a>
            <div class="flex items-center gap-3 ml-4">
                @if ($product->user)
                    <a href="{{ route('public.profile', [$product->user->id]) }}" class="flex items-center gap-2">
                        @if ($product->user->profile_photo_url)
                            <img src="{{ $product->user->profile_photo_url }}" alt="Foto de perfil"
                                class="w-9 h-9 rounded-full object-cover border border-gray-300">
                        @else
                            <span
                                class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user"></i>
                            </span>
                        @endif
                        <span class="font-medium">{{ $product->user->name }}</span>
                    </a>
                @else
                    <span class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <i class="fas fa-user"></i>
                    </span>
                    <span class="font-medium">Desconocido</span>
                @endif
            </div>
        </div>
    </div>
</div>
