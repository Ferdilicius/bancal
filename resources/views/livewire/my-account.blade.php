<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Mi perfil</h1>

        <div class="mb-4">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Productos</h2>
            <div class="mb-4 flex justify-end">
            <a href="{{ route('product.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i> Agregar Producto
            </a>
            </div>
            @if ($products->isNotEmpty())
            <div class="p-6 bg-gray-100">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Productos</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
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
                    <div class="mt-4 flex justify-between">
                        <a href="{{ route('product.show', $product->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200">
                        Ver
                        </a>
                        <a href="{{ route('product.edit', $product->id) }}"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors duration-200">
                        Editar
                        </a>
                    </div>
                    </div>
                @endforeach
                </div>
            </div>
            @else
            <p>No tienes productos</p>
            @endif
        </div>
    </div>
</div>
