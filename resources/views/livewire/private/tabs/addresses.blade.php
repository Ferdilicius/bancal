<div x-show="tab === 'terrenos'">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6 mb-8 sm:mb-10">
        <a href="{{ route('address.create') }}"
            class="inline-flex items-center justify-center bg-green-600 text-white px-5 sm:px-7 py-2 sm:py-3 rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-lg font-semibold text-sm sm:text-base w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i> Agregar Bancal
        </a>
    </div>

    @if ($addresses->isNotEmpty())
        <div class="grid gap-4 sm:gap-6 grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($addresses as $address)
                <div
                    class="relative bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-green-400 flex flex-col justify-between p-4 sm:p-6 group">
                    <a href="{{ route('address.show', $address) }}" class="block focus:outline-none cursor-pointer">
                        <div class="mb-4 sm:mb-5">
                            {{-- Aquí puedes poner una imagen del bancal si tienes --}}
                            <i class="fas fa-tree text-4xl text-green-400"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 sm:mb-2 truncate">
                            {{ $address->name }}
                        </h3>
                        <p class="text-gray-500 mb-1 sm:mb-2 truncate">{{ $address->description }}</p>
                        <div class="mb-1 sm:mb-2">
                            <span class="block text-gray-700 text-xs sm:text-sm">Ubicación: <span
                                    class="font-semibold">{{ $address->location }}</span></span>
                            <span class="block text-gray-700 text-xs sm:text-sm">Tamaño: <span
                                    class="font-semibold">{{ $address->size }} m²</span></span>
                        </div>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibol {{ $address->status === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if ($address->status === 'activo')
                                <i class="fas fa-check-circle text-green-500"></i> Activo
                            @else
                                <i class="fas fa-times-circle text-red-500"></i> Inactivo
                            @endif
                        </span>
                    </a>
                    <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('address.edit', $address->id) }}"
                            class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                        <form action="{{ route('address.delete', $address->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-xs sm:text-sm font-medium"
                                onclick="return confirm('¿Quieres borrar este bancal? No lo podrás recuperar.');">
                                <i class="fas fa-trash-alt mr-2"></i> Borrar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center mt-16 sm:mt-20">
            <i class="fas fa-tree text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">Aún no tienes
                bancales publicados</p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">¡Comienza a agregar bancales para que otros puedan
                verlos!</p>
        </div>
    @endif
</div>
