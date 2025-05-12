<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Perfil Público de {{ $user->name }}</h1>

        <div class="mb-4">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Productos</h2>
            @if ($user->products->isNotEmpty())
                <div class="p-6 bg-gray-100">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Productos</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($user->products as $product)
                            <a href="{{ route('product.show', $product->id) }}"
                                class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
                                <div class="mb-4">
                                    @if ($product->image)
                                        <img src="{{ $product->image }}" alt="Imagen del producto"
                                            class="w-full h-32 object-cover rounded">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center rounded">
                                            <span class="text-gray-500">Sin imagen</span>
                                        </div>
                                    @endif
                                </div>
                                <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                                <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                                <p class="text-gray-700 font-semibold mb-2">Cantidad: {{ $product->quantity }}</p>
                                <p class="text-gray-700 font-semibold mb-2">Precio: {{ $product->price }}</p>
                                <p>
                                    <span
                                        class="{{ $product->status ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                        {{ $product->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <p>Este usuario no tiene productos.</p>
            @endif
        </div>
    </div>
</div>
