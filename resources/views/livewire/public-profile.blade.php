@section('title', 'Perfil Público de ' . $user->name)

<div class="max-w-6xl mx-auto py-6 px-6 sm:px-12 text-lg">
    @php
        $previousUrl = url()->previous();
        $currentUrl = url()->current();

        if ($previousUrl === $currentUrl && request()->headers->has('referer')) {
            $previousUrl = request()->headers->get('referer');
        }
    @endphp
    <a href="{{ $previousUrl }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div class="bg-white shadow-xl rounded-3xl p-6 sm:p-10">
        <div class="flex items-center mb-10">
            @if ($user->profile_photo_url ?? false)
                <img src="{{ $user->profile_photo_url }}" alt="Foto de perfil de {{ $user->name }}"
                    class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 mr-6">
            @else
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mr-6">
                    <i class="fas fa-user text-4xl"></i>
                </div>
            @endif
            <h1 class="text-3xl font-extrabold text-gray-900">Perfil Público de {{ $user->name }}</h1>
        </div>
        <h2 class="text-2xl font-bold mt-12 mb-6 text-gray-900">Productos en venta</h2>
        @if ($products->isNotEmpty())
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($products as $product)
                    <a href="{{ route('product.show', $product->id) }}"
                        class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 flex flex-col p-4 group">
                        <div class="mb-4">
                            <x-product-image :product="$product" class="w-full h-32 object-cover rounded-lg" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 mb-1 truncate">
                                {{ $product->name }}
                            </h3>
                            <div class="text-gray-700 text-sm">
                                Cantidad: <span class="font-semibold">{{ $product->formatted_quantity }}</span>
                            </div>
                            <div class="text-gray-700 text-sm">
                                Precio: <span class="font-semibold">{{ $product->formatted_price }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center mt-20">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-6"></i>
                <p class="text-gray-500 text-center text-xl font-semibold mb-2">Este usuario no tiene productos
                    publicados.</p>
            </div>
        @endif

        <h2 class="text-2xl font-bold mt-12 mb-6 text-gray-900">Bancales</h2>
        @if ($addresses->isNotEmpty())
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($addresses as $address)
                    <div
                        class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 flex flex-col p-4 group">
                        <a href="{{ route('address.show', $address) }}" class="block focus:outline-none cursor-pointer">
                            <div class="mb-4">
                                @if ($address->images->first())
                                    <img src="{{ route('address.image', ['addressId' => $address->id, 'imageId' => $address->images->first()->id]) }}"
                                        class="w-full h-32 object-cover rounded-lg" alt="Imagen de dirección">
                                @else
                                    <div
                                        class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                        <i class="fas fa-map-marker-alt text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1 truncate">
                                {{ $address->name }}
                            </h3>
                            <p class="text-gray-500 text-sm truncate">{{ $address->address }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center mt-10">
                <i class="fas fa-map-marker-alt text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-center text-lg font-semibold mb-2">Este usuario no tiene direcciones
                    publicadas.</p>
            </div>
        @endif

    </div>
</div>
