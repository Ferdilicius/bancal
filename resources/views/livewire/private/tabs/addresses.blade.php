<div x-data="{
    tab: 'direcciones',
    selectedAddresses: @entangle('selectedAddresses'),
    openDeleteMultiple: false,
    allAddressIds: @js($addresses->pluck('id')),
    selectAll() {
        this.selectedAddresses = this.allAddressIds.slice();
    }
}" x-show="tab === 'direcciones'">

    <!-- Cabecera: botón agregar y eliminar múltiple -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6 mb-4">

        <a href="{{ route('address.create') }}"
            class="inline-flex items-center justify-center bg-green-600 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-lg font-semibold text-sm sm:text-base w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i> Agregar Dirección
        </a>

        <!-- Botones visibles solo si hay seleccionados -->
        <template x-if="selectedAddresses.length > 0">
            <div class="flex-1 flex gap-2">
                <!-- Seleccionar todos / Deseleccionar todos -->
                <button type="button"
                    @click="selectedAddresses.length === allAddressIds.length ? selectedAddresses = [] : selectAll()"
                    class="w-full bg-blue-600 text-white py-3 px-2 rounded-xl shadow hover:bg-blue-700 transition-colors duration-200 flex justify-center items-center text-sm font-semibold"
                    style="z-index:1; min-width: 0;">
                    <i class="fas"
                        :class="selectedAddresses.length === allAddressIds.length ? 'fa-times' : 'fa-check-double'"></i>
                    <span class="ml-1"
                        x-text="selectedAddresses.length === allAddressIds.length ? 'Deseleccionar todos' : 'Seleccionar todos'"></span>
                </button>
                <!-- Eliminar múltiple -->
                <button type="button" @click="openDeleteMultiple = true"
                    class="w-full bg-red-600 text-white py-3 px-2 rounded-xl shadow hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-sm font-semibold"
                    style="z-index:1; min-width: 0;">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Seleccionadas
                </button>
            </div>
        </template>

        <!-- Modal confirmación eliminación múltiple -->
        <div x-show="openDeleteMultiple" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-xl shadow-lg p-6 max-w-xs w-full text-center"
                @click.away="openDeleteMultiple = false" @keydown.escape.window="openDeleteMultiple = false">
                <h2 class="text-lg font-bold mb-4 text-gray-900">¿Borrar direcciones seleccionadas?</h2>
                <p class="mb-6 text-gray-600 text-sm">Esta acción es irreversible.</p>
                <div class="flex gap-4 justify-center">
                    <button type="button" wire:click="deleteMultipleAddresses" wire:loading.attr="disabled"
                        class="inline-flex items-center bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition-colors duration-200 shadow font-semibold text-sm"
                        @click="openDeleteMultiple = false">
                        <i class="fas fa-trash-alt mr-1"></i> Sí, borrar
                    </button>
                    <button type="button" @click="openDeleteMultiple = false"
                        class="bg-gray-200 text-gray-800 px-3 py-2 rounded-lg hover:bg-gray-300 transition-colors font-semibold text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Direcciones -->
    @if ($addresses->isNotEmpty())
        <div class="grid gap-4 sm:gap-6 grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($addresses as $address)
                <div
                    class="relative bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 flex flex-col justify-between p-4 sm:p-6 group">

                    <!-- Checkbox -->
                    <div class="absolute top-3 left-3 z-10">
                        <input type="checkbox" wire:model="selectedAddresses" value="{{ $address->id }}"
                            class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                    </div>

                    <!-- Enlace a detalle -->
                    <a href="{{ route('address.show', $address) }}" class="block focus:outline-none cursor-pointer">
                        <div class="mb-4 sm:mb-5">
                            {{-- Aquí puedes poner una imagen de la dirección si tienes --}}
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
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2 truncate">
                            {{ $address->name }}
                        </h3>
                        <p class="text-gray-500 mb-1 sm:mb-2 truncate">{{ $address->address }}</p>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold 
                            {{ $address->status === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if ($address->status === 'activo')
                                <i class="fas fa-check-circle text-green-500"></i> Activa
                            @else
                                <i class="fas fa-times-circle text-red-500"></i> Inactiva
                            @endif
                        </span>
                    </a>

                    <!-- Acciones -->
                    <div class="mt-4 sm:mt-6 flex flex-col gap-2 w-full flex-wrap sm:flex-row sm:gap-2">
                        <!-- Editar -->
                        <a href="{{ route('address.edit', $address->id) }}"
                            class="flex-1 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-2 rounded-lg transition-colors duration-200 flex flex-row justify-center items-center text-xs sm:text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 sm:mb-0">
                            <i class="fas fa-edit mr-2"></i>
                            <span class="sm:inline">Editar</span>
                        </a>
                        <div class="flex flex-col sm:flex-row gap-2 w-full">
                            <!-- Borrar -->
                            <div x-data="{ open: false }" class="flex-1 w-full">
                                <button type="button"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-2 rounded-lg transition-colors duration-200 flex flex-row justify-center items-center text-xs sm:text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-red-400"
                                    @click="open = true">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    <span class="sm:inline">Borrar</span>
                                </button>
                                <div x-show="open" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-red-200"
                                        @click.away="open = false" @keydown.escape.window="open = false">
                                        <h2 class="text-xl font-bold mb-4 text-gray-900">¿Borrar dirección?</h2>
                                        <p class="mb-6 text-gray-600 text-sm">Esta acción es irreversible y no podrás recuperarla.</p>
                                        <div class="flex gap-4 justify-center">
                                            <button wire:click="deleteAddress({{ $address->id }})"
                                                wire:loading.attr="disabled" @click="open = false"
                                                class="inline-flex items-center bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg transition-colors duration-200 shadow font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                                                <i class="fas fa-trash-alt mr-2"></i> Sí, borrar
                                            </button>
                                            <button type="button" @click="open = false"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded-lg transition-colors font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Duplicar -->
                            <div x-data="{ openDuplicate: false }" class="flex-1 w-full">
                                <button type="button"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-2 rounded-lg transition-colors duration-200 flex flex-row justify-center items-center text-xs sm:text-sm font-medium shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                    @click="openDuplicate = true">
                                    <i class="fas fa-copy mr-2"></i>
                                    <span class="sm:inline">Duplicar</span>
                                </button>
                                <div x-show="openDuplicate" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center border border-yellow-200"
                                        @click.away="openDuplicate = false"
                                        @keydown.escape.window="openDuplicate = false">
                                        <h2 class="text-xl font-bold mb-4 text-gray-900">¿Duplicar dirección?</h2>
                                        <p class="mb-6 text-gray-600 text-sm">Se creará una copia de esta dirección.</p>
                                        <div class="flex gap-4 justify-center">
                                            <button wire:click="duplicateAddress({{ $address->id }})"
                                                wire:loading.attr="disabled" @click="openDuplicate = false"
                                                class="inline-flex items-center bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 shadow font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                                <i class="fas fa-copy mr-2"></i> Sí, duplicar
                                            </button>
                                            <button type="button" @click="openDuplicate = false"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded-lg transition-colors font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                Cancelar
                                            </button>
                                        </div>
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
            <i class="fas fa-map-marker-alt text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">Aún no tienes
                direcciones
                guardadas</p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">¡Comienza a agregar direcciones para usarlas en tus
                pedidos!</p>
        </div>
    @endif
</div>
