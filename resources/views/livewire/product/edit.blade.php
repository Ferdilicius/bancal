@section('title', 'Editar Producto')

<div class="max-w-3xl mx-auto p-8 my-10 bg-white shadow rounded border border-gray-200">
    <h1 class="text-3xl font-bold text-indigo-700 mb-8 text-center">Editar Producto</h1>
    <form wire:submit.prevent="updateProduct" class="space-y-8" enctype="multipart/form-data">

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-base font-semibold text-gray-800">Nombre del Producto</label>
            <input type="text" id="name" wire:model="name"
                class="mt-2 block w-64 border border-gray-300 rounded px-4 py-2 focus:ring-indigo-400 focus:border-indigo-400">
            @error('name')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descripción --}}
        <div>
            <label for="description" class="block text-base font-semibold text-gray-800">Descripción</label>
            <textarea id="description" wire:model="description"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 resize-none min-h-[90px] focus:ring-indigo-400 focus:border-indigo-400"></textarea>
            @error('description')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cantidad --}}
        <div>
            <label for="quantity" class="block text-base font-semibold text-gray-800">Cantidad</label>
            <input type="number" id="quantity" wire:model="quantity" min="1" step="1"
                class="mt-2 block w-48 border border-gray-300 rounded px-4 py-2 text-base focus:ring-indigo-400 focus:border-indigo-400"
                oninput="this.value = Math.max(1, parseInt(this.value) || 1)">
            @error('quantity')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Precio --}}
        <div>
            <label for="price" class="block text-base font-semibold text-gray-800">Precio</label>
            <input type="number" id="price" wire:model="price" min="0.01" step="0.01"
                class="mt-2 block w-48 border border-gray-300 rounded px-4 py-2 text-base focus:ring-indigo-400 focus:border-indigo-400"
                oninput="this.value = Math.max(0.01, parseFloat(this.value) || 0.01)">
            @error('price')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Vista con imágenes reordenables usando Alpine.js --}}
        <div x-data="{ dragIndex: null }">
            <label for="images-upload" class="block text-base font-semibold text-gray-800 mb-2">Imágenes del
                Producto</label>

            <label for="images-upload" class="block w-full cursor-pointer">
                <input id="images-upload" type="file" wire:model="newImages" multiple accept="image/*"
                    class="hidden" />
                <span
                    class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-sm px-4 py-2 rounded border border-gray-300 hover:bg-indigo-100 transition">
                    <i class="fas fa-images mr-2"></i> Seleccionar imágenes
                </span>
            </label>

            @error('images.*')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror

            @if ($images && count($images) > 0)
                <div class="mt-4 flex flex-wrap gap-4">
                    @foreach ($images as $key => $image)
                        <div class="relative group" draggable="true" @dragstart="dragIndex = {{ $key }}"
                            @dragover.prevent @drop="$wire.moveImage(dragIndex, {{ $key }}); dragIndex = null"
                            :class="{ 'ring-2 ring-indigo-400': dragIndex === {{ $key }} }">
                            @if (is_object($image) && method_exists($image, 'temporaryUrl'))
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-64 h-64 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Vista previa">
                            @else
                                <img src="{{ asset('storage/' . $image) }}"
                                    class="w-64 h-64 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
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

            {{-- Vista previa de imágenes existentes --}}
            @if (isset($oldImages) && count($oldImages) > 0)
                <div class="mt-4 flex flex-wrap gap-4">
                    @foreach ($oldImages as $oldKey => $oldImage)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $oldImage) }}"
                                class="w-64 h-64 object-cover rounded-lg border-2 border-gray-200 shadow group-hover:scale-105 transition-transform duration-200"
                                alt="Imagen actual">
                            <button type="button" wire:click="removeOldImage({{ $oldKey }})"
                                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold shadow hover:bg-red-700 transition"
                                title="Quitar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Estado con radios y colores mejorado (sin icono, más grande) --}}
        <div>
            <label class="block text-lg font-bold text-gray-800 mb-3">Estado</label>
            <div class="flex items-center gap-12">
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
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Categoría --}}
        <div>
            <label for="category_id" class="block text-base font-semibold text-gray-800">Categoría</label>
            <select id="category_id" wire:model="category_id"
                class="mt-2 block w-full border border-gray-300 rounded px-4 py-2 bg-white focus:ring-indigo-400 focus:border-indigo-400">
                <option value="" selected>Selecciona una categoría</option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <button type="submit"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-3 px-6 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-600 font-bold text-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                <i class="fas fa-save mr-2"></i> Actualizar Producto
            </button>
            <div x-data="{ open: false }" class="flex-1">
                <button type="button" @click="open = true"
                    class="w-full bg-red-600 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                    style="z-index:1;">
                    <i class="fas fa-trash-alt mr-2"></i> Borrar Producto
                </button>

                <!-- Modal de confirmación -->
                <div x-show="open" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                    <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center"
                        @click.away="open = false" @keydown.escape.window="open = false">
                        <h2 class="text-xl font-bold mb-4 text-gray-900">¿Seguro que quieres borrar este producto?</h2>
                        <p class="mb-6 text-gray-600">Esta acción es irreversible y no podrás recuperarlo.</p>
                        <div class="flex gap-4 justify-center">
                            <button type="button" wire:click="deleteProduct"
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
</div>
