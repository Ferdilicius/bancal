<div x-show="tab === 'productos'">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6 mb-8 sm:mb-10">
        <a href="{{ route('product.create') }}"
            class="inline-flex items-center justify-center bg-green-600 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-lg font-semibold text-sm sm:text-base w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i> Agregar Producto
        </a>
    </div>

    @if ($products->isNotEmpty())
        <div class="grid gap-4 sm:gap-6 grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $product)
                <div
                    class="relative bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 flex flex-col justify-between p-4 sm:p-6 group">
                    <a href="{{ route('product.show', $product) }}" class="block focus:outline-none cursor-pointer">
                        <div class="mb-4 sm:mb-5">
                            <x-product-image :product="$product" />
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2 truncate">
                            {{ $product->name }}
                        </h3>
                        <p class="text-gray-500 mb-1 sm:mb-2 truncate">{{ $product->description }}</p>
                        <div class="mb-1 sm:mb-2">
                            <span class="block text-gray-700 text-xs sm:text-sm">Cantidad: <span
                                    class="font-semibold">{{ $product->quantity }}
                                    {{ $product->quantity_type }}</span></span>
                            <span class="block text-gray-700 text-xs sm:text-sm">Precio: <span
                                    class="font-semibold">${{ number_format($product->price, 2) }}</span></span>
                        </div>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibol {{ $product->status === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if ($product->status === 'activo')
                                <i class="fas fa-check-circle text-green-500"></i> Activo
                            @else
                                <i class="fas fa-times-circle text-red-500"></i> Inactivo
                            @endif
                        </span>
                    </a>
                    <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('product.edit', $product->id) }}"
                            class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                        <form action="{{ route('product.delete', $product->id) }}" method="GET" class="flex-1">
                            <button type="submit"
                                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium"
                                onclick="return confirm('¿Quieres borrar este producto? No lo podrás recuperar.');">
                                <i class="fas fa-trash-alt mr-2"></i> Borrar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center mt-16 sm:mt-20">
            <i class="fas fa-box-open text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">Aún no tienes
                productos publicados</p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">¡Comienza a agregar productos para que otros
                puedan verlos!</p>
        </div>
    @endif
</div>
