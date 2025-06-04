@section('title', "$address->address - Detalles de Dirección")

<div class="max-w-3xl mx-auto py-12 px-4 sm:px-8">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-8 border-b border-gray-200 pb-4">
            Detalles de la Dirección
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="space-y-6 text-base text-gray-700">
                <div>
                    <span class="font-semibold text-gray-800">Dirección:</span>
                    <span class="ml-2">{{ $address->address }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Nombre:</span>
                    <span class="ml-2">{{ $address->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Tipo:</span>
                    <span class="ml-2">{{ $address->addressType->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Estado:</span>
                    <span class="ml-2">
                        <span
                            class="inline-block px-2 py-1 rounded text-xs font-semibold
                            {{ $address->status === 'activo' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($address->status) }}
                        </span>
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Usuario:</span>
                    <span class="ml-2">
                        @if ($address->user)
                            <a href="{{ route('public.profile', [$address->user->id]) }}"
                                class="text-blue-600 hover:underline">
                                {{ $address->user->name }}
                            </a>
                        @else
                            Desconocido
                        @endif
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Creado:</span>
                    <span class="ml-2">{{ $address->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-800">Actualizado:</span>
                    <span class="ml-2">{{ $address->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center w-full max-w-xs relative group">
                @if ($address->image)
                    <img src="{{ asset('storage/' . $address->image) }}" alt="Imagen de la dirección"
                        class="w-full h-40 object-cover rounded-lg shadow">
                @else
                    <div
                        class="flex items-center justify-center w-full h-32 bg-gray-100 rounded-lg border border-gray-200 shadow-sm text-gray-500 text-sm font-semibold">
                        Sin imagen
                    </div>
                @endif
            </div>
        </div>
        <div class="mt-10 flex flex-col sm:flex-row gap-4 items-center">
            <a href="{{ route('address.edit', $address) }}"
                class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                <i class="fas fa-edit"></i>
                <span>Editar</span>
            </a>
            <a href="{{ route('address.index') }}"
                class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>
</div>
