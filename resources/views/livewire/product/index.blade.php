@section('title', 'Todos los Productos')

<div class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Productos</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <a href="{{ route('product.show', $product->id) }}"
                class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">

                <x-product-image :product="$product" />

                <div class="flex items-center mt-2 mb-2">
                    <img src="{{ $product->user ? $product->user->profile_photo_url : 'https://ui-avatars.com/api/?name=Vendedor+desconocido&background=cccccc&color=555555&size=64' }}"
                        alt="{{ $product->user->name ?? 'Vendedor desconocido' }}"
                        class="w-8 h-8 rounded-full mr-2 border border-gray-300">
                    <span class="text-gray-700 text-sm">{{ $product->user->name ?? 'Vendedor desconocido' }}</span>
                </div>

                <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                <p class="text-gray-700 font-semibold mb-2">Cantidad: {{ $product->quantity }}</p>
                <p class="text-gray-700 font-semibold mb-2">Precio: {{ $product->price }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        <div class="bg-white p-4 rounded-lg shadow-md">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</div>
