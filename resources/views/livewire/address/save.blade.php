@section('title', $address_id ? 'Editar Dirección' : 'Crear Dirección')

<div class="max-w-3xl mx-auto p-8 my-10 bg-white shadow rounded border border-gray-200">
    <h1 class="text-3xl font-bold text-indigo-700 mb-8 text-center">
        {{ $address_id ? 'Editar Dirección' : 'Crear Dirección' }}
    </h1>
    <div x-data class="space-y-8">
        {{-- Dirección --}}
        <div>
            <label for="address" class="block text-base font-semibold text-gray-800">Dirección</label>
            <input type="text" id="address" wire:model="address"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 focus:ring-indigo-400 focus:border-indigo-400">
            @error('address')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-base font-semibold text-gray-800">Nombre (opcional)</label>
            <input type="text" id="name" wire:model="name"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 focus:ring-indigo-400 focus:border-indigo-400">
            @error('name')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Imagen --}}
        <div>
            <label for="image" class="block text-base font-semibold text-gray-800">Imagen (URL opcional)</label>
            <input type="text" id="image" wire:model="image"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 focus:ring-indigo-400 focus:border-indigo-400"
                placeholder="https://...">
            @error('image')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
            @if ($image)
                <div class="mt-3">
                    <img src="{{ $image }}" alt="Vista previa"
                        class="w-32 h-32 object-cover rounded border border-indigo-200 shadow">
                </div>
            @endif
        </div>

        {{-- Estado --}}
        <div>
            <label class="block text-lg font-bold text-gray-800 mb-3">Estado</label>
            <div class="flex items-center gap-12">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="activo"
                        class="form-radio w-6 h-6 text-green-600 focus:ring-green-500 transition-all duration-150" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-green-700 transition">
                        Activo
                    </span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="inactivo"
                        class="form-radio w-6 h-6 text-red-600 focus:ring-red-500 transition-all duration-150" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-red-700 transition">
                        Inactivo
                    </span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tipo de Dirección --}}
        <div>
            <label for="address_type_id" class="block text-base font-semibold text-gray-800">Tipo de Dirección</label>
            <select id="address_type_id" wire:model="address_type_id"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring-indigo-400 focus:border-indigo-400">
                <option value="" selected>Selecciona un tipo</option>
                @foreach ($addressTypes ?? [] as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('address_type_id')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <button type="button" wire:click="save"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-6 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-600 font-bold text-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> {{ $address_id ? 'Actualizar Dirección' : 'Crear Dirección' }}
            </button>
            @if ($address_id)
                <div x-data="{ open: false }" class="flex-1">
                    <button type="button" @click="open = true"
                        class="w-full bg-red-600 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                        style="z-index:1;">
                        <i class="fas fa-trash-alt mr-2"></i> Borrar Dirección
                    </button>
                    <!-- Modal de confirmación -->
                    <div x-show="open" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center"
                            @click.away="open = false" @keydown.escape.window="open = false">
                            <h2 class="text-xl font-bold mb-4 text-gray-900">¿Seguro que quieres borrar esta dirección?
                            </h2>
                            <p class="mb-6 text-gray-600">Esta acción es irreversible y no podrás recuperarla.</p>
                            <div class="flex gap-4 justify-center">
                                <button type="button" wire:click="delete({{ $address_id }})"
                                    class="inline-flex items-center bg-red-700 text-white px-7 py-3 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base">
                                    <i class="fas fa-trash-alt mr-2"></i> Sí, borrar
                                </button>
                                <button type="button" @click="open = false"
                                    class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <a href="{{ route('private-profile') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 py-3 px-6 rounded-lg shadow-lg hover:from-gray-300 hover:to-gray-400 font-bold text-lg transition-all duration-200 text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 border border-gray-300">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 mr-2">
                    <i class="fas fa-arrow-left"></i>
                </span>
                Cancelar
            </a>
        </div>
        </form>
        @if (session()->has('message'))
            <div class="mt-6 text-center">
                <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded font-semibold">
                    {{ session('message') }}
                </span>
            </div>
        @endif
    </div>
