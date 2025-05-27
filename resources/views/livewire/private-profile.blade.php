@section('title', 'Mi perfil')

<div class="max-w-6xl mx-auto mt-14 px-2 sm:px-6 mb-10">
    <div class="bg-white shadow-xl rounded-3xl p-6 sm:p-10">
        <h1 class="text-3xl font-extrabold mb-10 text-gray-900">Mi perfil</h1>

        <div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
                <a href="{{ route('product.create') }}"
                    class="inline-flex items-center bg-green-600 text-white px-7 py-3 rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-lg font-semibold text-base">
                    <i class="fas fa-plus mr-2"></i> Agregar Producto
                </a>
            </div>

            @if ($products->isNotEmpty())
                <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($products as $product)
                        <div
                            class="relative bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 flex flex-col justify-between p-6 group">
                            <a href="{{ route('product.show', $product->id) }}" class="block focus:outline-none">
                                <div class="mb-5">
                                    <x-product-image :product="$product" />
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-500 mb-2 truncate">{{ $product->description }}</p>
                                <div class="mb-2">
                                    <span class="block text-gray-700 text-sm">Cantidad: <span
                                            class="font-semibold">{{ $product->quantity }}</span></span>
                                    <span class="block text-gray-700 text-sm">Precio: <span
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
                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('product.edit', $product->id) }}"
                                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex justify-center items-center text-sm font-medium"
                                    onclick="event.stopPropagation();">
                                    <i class="fas fa-edit mr-2"></i> Editar
                                </a>
                                <!-- Botón y modal usando Alpine.js -->
                                <div x-data="{ open: false }" class="flex-1">
                                    <button type="button" @click="open = true"
                                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-sm font-medium"
                                        style="z-index:1;">
                                        <i class="fas fa-trash-alt mr-2"></i> Borrar
                                    </button>

                                    <!-- Modal de confirmación -->
                                    <div x-show="open" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center"
                                            @click.away="open = false" @keydown.escape.window="open = false">
                                            <h2 class="text-xl font-bold mb-4 text-gray-900">¿Seguro quieres borrar este
                                                producto?</h2>
                                            <p class="mb-6 text-gray-600">No lo podrás recuperar.</p>
                                            <div class="flex gap-4 justify-center">
                                                <a href="{{ route('product.delete', $product->id) }}"
                                                    class="inline-flex items-center bg-red-600 text-white px-7 py-3 rounded-xl hover:bg-red-700 transition-colors duration-200 shadow-lg font-semibold text-base">
                                                    <i class="fas fa-trash-alt mr-2"></i> Borrar
                                                </a>
                                                <button type="button" @click="open = false"
                                                    class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center mt-20">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-6"></i>
                    <p class="text-gray-500 text-center text-xl font-semibold mb-2">Aún no tienes productos publicados
                    </p>
                    <p class="text-gray-400 text-center mb-4">¡Comienza a agregar productos para que otros puedan
                        verlos!</p>
                </div>
            @endif
        </div>
    </div>
</div>
