@section('title', 'Todos los Productos')

<div class="p-6 bg-gray-100">
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
                    @php
                        $firstImage = $product->images->first();
                    @endphp
                    @if ($firstImage)
                        <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $firstImage->id]) }}"
                            alt="Imagen producto" class="w-full h-48 object-cover rounded-t-lg mb-2">
                    @else
                        <div
                            class="w-full h-48 bg-gray-300 flex items-center justify-center rounded-t-lg mb-2 text-gray-500">
                            Sin imagen
                        </div>
                    @endif

                    <div class="flex items-center mt-2 mb-2">
                        <img src="{{ $product->user ? $product->user->profile_photo_url : 'https://ui-avatars.com/api/?name=Vendedor+desconocido&background=cccccc&color=555555&size=64' }}"
                            alt="{{ $product->user->name ?? 'Vendedor desconocido' }}"
                            class="w-8 h-8 rounded-full mr-2 border border-gray-300">
                        <span class="text-gray-700 text-sm">{{ $product->user->name ?? 'Vendedor desconocido' }}</span>
                    </div>

                    <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-700 font-semibold mb-2">Cantidad: {{ $product->formatted_quantity }}</p>
                    <p class="text-gray-700 font-semibold mb-2">Precio: {{ $product->price }}€</p>
                </a>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            <div class="bg-white p-4 rounded-lg shadow-md">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center min-h-[40vh] sm:min-h-[60vh]">
            <i class="fas fa-search text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">
                No existen productos que coincidan con tu búsqueda
            </p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">
                Intenta modificar los filtros o la búsqueda para ver otros productos.
            </p>
        </div>
    @endif
</div>
