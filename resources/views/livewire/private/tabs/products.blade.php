<div x-show="tab === 'productos'">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6 mb-4">
        <a href="{{ route('product.create') }}"
            class="inline-flex items-center justify-center bg-green-600 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-lg font-semibold text-sm sm:text-base w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i> Agregar Producto
        </a>

        {{-- Botón eliminar múltiples --}}
        @if ($products->isNotEmpty())
            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="selectAll"
                        class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Seleccionar todos</span>
                </label>

                {{-- Este botón solo aparece si hay productos seleccionados --}}
                @if (count($selectedProducts) > 0)
                    <div x-data="{ openDeleteMultiple: false }" class="flex-1">
                        <button type="button" @click="openDeleteMultiple = true"
                            class="w-full bg-red-600 text-white py-4 px-8 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                            style="z-index:1;">
                            <i class="fas fa-trash-alt mr-2"></i> Eliminar seleccionados
                        </button>
                        <!-- Modal de confirmación múltiple -->
                        <div x-show="openDeleteMultiple" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                            <div class="bg-white rounded-xl shadow-lg p-10 max-w-sm w-full text-center"
                                @click.away="openDeleteMultiple = false"
                                @keydown.escape.window="openDeleteMultiple = false">
                                <h2 class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres borrar los
                                    productos seleccionados?</h2>
                                <p class="mb-8 text-gray-600">Esta acción es irreversible y no podrás recuperarlos.</p>
                                <div class="flex gap-6 justify-center">
                                    <button type="button" wire:click="deleteMultipleProducts"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center bg-red-700 text-white px-8 py-4 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base"
                                        @click="openDeleteMultiple = false">
                                        <i class="fas fa-trash-alt mr-2"></i> Sí, borrar
                                    </button>
                                    <button type="button" @click="openDeleteMultiple = false"
                                        class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>

    @if ($products->isNotEmpty())
        <div class="grid gap-4 sm:gap-6 grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($products as $product)
                <div
                    class="relative bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 flex flex-col justify-between p-4 sm:p-6 group">

                    {{-- Checkbox --}}
                    <div class="absolute top-3 left-3 z-10">
                        <input type="checkbox" wire:model="selectedProducts" value="{{ $product->id }}"
                            class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                    </div>

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

                    {{-- Botones individuales --}}
                    <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('product.edit', $product->id) }}"
                            class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                        {{-- Botón duplicar --}}
                        {{-- Botón duplicar con confirmación --}}
                        <div x-data="{ openDuplicate: false }" class="flex-1">
                            <button type="button"
                                class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium"
                                @click="openDuplicate = true">
                                <i class="fas fa-copy mr-2"></i> Duplicar
                            </button>
                            <div x-show="openDuplicate" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center"
                                    @click.away="openDuplicate = false" @keydown.escape.window="openDuplicate = false">
                                    <h2 class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres duplicar este
                                        producto?</h2>
                                    <p class="mb-8 text-gray-600">Se creará una copia de este producto.</p>
                                    <div class="flex gap-6 justify-center">
                                        <button wire:click="duplicateProduct({{ $product->id }})"
                                            wire:loading.attr="disabled" @click="openDuplicate = false"
                                            class="inline-flex items-center bg-yellow-600 text-white px-8 py-4 rounded-xl hover:bg-yellow-700 transition-colors duration-200 shadow-lg font-semibold text-base">
                                            <i class="fas fa-copy mr-2"></i> Sí, duplicar
                                        </button>
                                        <button type="button" @click="openDuplicate = false"
                                            class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="flex-1">
                            <button type="button"
                                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium"
                                @click="open = true">
                                <i class="fas fa-trash-alt mr-2"></i> Borrar
                            </button>
                            <div x-show="open" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center"
                                    @click.away="open = false" @keydown.escape.window="open = false">
                                    <h2 class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres borrar este
                                        producto?</h2>
                                    <p class="mb-8 text-gray-600">Esta acción es irreversible y no podrás recuperarlo.
                                    </p>
                                    <div class="flex gap-6 justify-center">
                                        <button wire:click="deleteProduct({{ $product->id }})"
                                            wire:loading.attr="disabled" @click="open = false"
                                            class="inline-flex items-center bg-red-700 text-white px-8 py-4 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base">
                                            <i class="fas fa-trash-alt mr-2"></i> Sí, borrar
                                        </button>
                                        <button type="button" @click="open = false"
                                            class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
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
        <div class="flex flex-col items-center mt-16 sm:mt-20">
            <i class="fas fa-box-open text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">Aún no tienes
                productos publicados</p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">¡Comienza a agregar productos para que otros
                puedan verlos!</p>
        </div>
    @endif
</div>
