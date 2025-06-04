@section('title', $productId ? 'Editar Producto' : 'Crear Producto')

<div x-data="{
    submit() { $wire.save() }
}" class="max-w-3xl mx-auto p-10 my-14 bg-white shadow rounded border border-gray-200">
    <h1 class="text-3xl font-bold text-indigo-700 mb-10 text-center">
        {{ $productId ? 'Editar Producto' : 'Crear Producto' }}
    </h1>
    <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">
        {{-- Nombre --}}
        <div class="mb-6">
            <label for="name" class="block text-base font-semibold text-gray-800 mb-2">Nombre del Producto</label>
            <input type="text" id="name" wire:model="name"
                class="mt-2 block w-64 border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400">
            @error('name')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-6">
            <label for="description" class="block text-base font-semibold text-gray-800 mb-2">Descripción</label>
            <textarea id="description" wire:model="description"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 resize-none min-h-[90px] focus:ring-indigo-400 focus:border-indigo-400"></textarea>
            @error('description')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-6">
            <label for="price" class="block text-base font-semibold text-gray-800 mb-2">Precio</label>
            <input type="number" id="price" wire:model="price" min="0" step="0.01"
                class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
            @error('price')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cantidad --}}
        <div class="mb-6">
            <label for="quantity" class="block text-base font-semibold text-gray-800 mb-2">Cantidad</label>
            <input type="number" id="quantity" wire:model="quantity" min="0" step="1"
                class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
            @error('quantity')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-8">
            <label for="category_id" class="block text-base font-semibold text-gray-800 mb-2">Categoría</label>
            <select id="category_id" wire:model="category_id"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400">
                <option value="" selected>Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tipo de Unidad --}}
        <div class="mb-6">
            <label for="quantity_type" class="block text-base font-semibold text-gray-800 mb-2">Tipo de Unidad</label>
            <select id="quantity_type" wire:model="quantity_type"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400">
                <option value="" selected>Selecciona un tipo de unidad</option>
                @foreach ($quantityTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            @error('quantity_type')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Imágenes --}}
        <div class="mb-8" x-data="{ dragIndex: null }">
            <label for="images-upload" class="block text-base font-semibold text-gray-800 mb-3">Imágenes del
                Producto</label>
            <label for="images-upload" class="block w-full cursor-pointer mb-3">
                <input id="images-upload" type="file" wire:model="newImages" multiple accept="image/*"
                    class="hidden" />
                <span
                    class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-sm px-5 py-3 rounded border border-gray-300 hover:bg-indigo-100 transition">
                    <i class="fas fa-images mr-2"></i> Seleccionar imágenes
                </span>
            </label>
            @error('images.*')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror

            @if ($images && count($images) > 0)
                <div class="mt-5 flex flex-wrap gap-6">
                    @foreach ($images as $key => $image)
                        <div class="relative group" draggable="true" @dragstart="dragIndex = {{ $key }}"
                            @dragover.prevent @drop="$wire.moveImage(dragIndex, {{ $key }}); dragIndex = null"
                            :class="{ 'ring-2 ring-indigo-400': dragIndex === {{ $key }} }">
                            @if (is_object($image) && method_exists($image, 'temporaryUrl'))
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-32 h-32 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Vista previa">
                            @else
                                <img src="{{ asset('storage/' . $image) }}"
                                    class="w-32 h-32 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Vista previa">
                            @endif
                            <button type="button" wire:click="removeImage({{ $key }})"
                                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold shadow hover:bg-red-700 transition z-20"
                                title="Quitar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Permitir fraccionar --}}
        <div class="mb-6" x-data="{ fractional: @entangle('allow_fractional').defer }">
            <label class="block text-base font-semibold text-gray-800 mb-3">¿Permitir fraccionar?</label>
            <label class="inline-flex items-center gap-3">
                <input type="checkbox" wire:model="allow_fractional" x-model="fractional"
                    class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150">
                <span class="text-base">Sí</span>
            </label>
            @error('allow_fractional')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror

            <div x-show="fractional" x-transition>
                {{-- Mínimo por persona --}}
                <div class="mt-6">
                    <label for="min_per_person" class="block text-base font-semibold text-gray-800 mb-2">Mínimo por
                        persona</label>
                    <input type="number" id="min_per_person" wire:model="min_per_person" min="0"
                        step="any"
                        class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
                    @error('min_per_person')
                        <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Máximo por persona --}}
                <div class="mt-6">
                    <label for="max_per_person" class="block text-base font-semibold text-gray-800 mb-2">Máximo por
                        persona</label>
                    <input type="number" id="max_per_person" wire:model="max_per_person" min="0"
                        step="any"
                        class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
                    @error('max_per_person')
                        <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="mb-8">
            <label class="block text-lg font-bold text-gray-800 mb-4">Estado</label>
            <div class="flex items-center gap-16">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="1"
                        class="form-radio w-6 h-6 text-green-600 focus:ring-green-500 transition-all duration-150" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-green-700 transition">
                        Activo
                    </span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="0"
                        class="form-radio w-6 h-6 text-red-600 focus:ring-red-500 transition-all duration-150" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-red-700 transition">
                        Inactivo
                    </span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-6 mt-12">
            <button type="button" @click="submit"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-4 px-8 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-600 font-bold text-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> {{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}
            </button>
            @if ($productId)
                <div x-data="{ open: false }" class="flex-1">
                    <button type="button" @click="open = true"
                        class="w-full bg-red-600 text-white py-4 px-8 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                        style="z-index:1;">
                        <i class="fas fa-trash-alt mr-2"></i> Borrar Producto
                    </button>
                    <!-- Modal de confirmación -->
                    <div x-show="open" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                        <div class="bg-white rounded-xl shadow-lg p-10 max-w-sm w-full text-center"
                            @click.away="open = false" @keydown.escape.window="open = false">
                            <h2 class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres borrar este producto?
                            </h2>
                            <p class="mb-8 text-gray-600">Esta acción es irreversible y no podrás recuperarlo.</p>
                            <div class="flex gap-6 justify-center">
                                <button type="button" wire:click="delete"
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
            @endif
            <a href="{{ route('private-profile') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 py-4 px-8 rounded-lg shadow-lg hover:from-gray-300 hover:to-gray-400 font-bold text-lg transition-all duration-200 text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 border border-gray-300">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 mr-2">
                    <i class="fas fa-arrow-left"></i>
                </span>
                Cancelar
            </a>
        </div>
    </div>
</div>
