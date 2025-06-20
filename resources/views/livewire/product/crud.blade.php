@section('title', $productId ? 'Editar Producto' : 'Crear Producto')

<div class="max-w-6xl mx-auto py-16 px-6 sm:px-12 text-lg">
    <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div x-data="{
        submit() { $wire.save() }
    }" class="mx-auto p-12 bg-white shadow-lg rounded-lg border border-gray-200"
        role="form" aria-labelledby="product-form-title">

        <h1 id="product-form-title" class="text-2xl font-bold text-indigo-700 mb-10 text-center">
            {{ $productId ? 'Editar Producto' : 'Crear Producto' }}
        </h1>
        <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">

            {{-- Nombre --}}
            <div>
                <label for="name" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Nombre
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el nombre del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Este es el nombre público del producto. Usa un nombre claro y reconocible para que los
                            compradores lo encuentren fácilmente.
                        </div>
                    </span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                @error('name')
                    <span class="text-sm text-red-500 mt-2 block">{{ str_replace('name', 'nombre', $message) }}</span>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    Descripción
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre la descripción del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Describe brevemente el producto, sus características, usos o cualquier información relevante
                            para el comprador.
                        </div>
                    </span>
                </label>
                <textarea id="description" wire:model="description"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 resize-none min-h-[90px] focus:ring-indigo-400 focus:border-indigo-400 text-base"></textarea>
                @error('description')
                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Precio y Cantidad --}}
            <div class="flex flex-col gap-6 sm:flex-row">
                <div class="flex-1">
                    <label for="price" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                        <span class="text-red-600">*</span> Precio (€)
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el precio">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                role="tooltip">
                                Indica el precio de venta del producto en euros. Usa punto para decimales.
                            </div>
                        </span>
                    </label>
                    <input type="text" id="price" wire:model="price"
                        class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                        inputmode="decimal" pattern="^\d+(\.\d{0,2})?$"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^(\d*\.\d{0,2}).*$/, '$1')">
                    @error('price')
                        <span class="text-sm text-red-500 mt-2 block">{{ str_replace('price', 'precio', $message) }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="quantity" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                        <span class="text-red-600">*</span> Cantidad
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre la cantidad">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                role="tooltip">
                                Especifica la cantidad total disponible para la venta. Solo números enteros.
                            </div>
                        </span>
                    </label>
                    <input type="text" id="quantity" wire:model="quantity"
                        class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                        inputmode="numeric" pattern="^\d*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('quantity')
                        <span
                            class="text-sm text-red-500 mt-2 block">{{ str_replace('quantity', 'cantidad', $message) }}</span>
                    @enderror
                </div>
            </div>

            {{-- Tipo de Unidad y Categoría --}}
            <div class="flex flex-col gap-6 sm:flex-row">
                {{-- Tipo de Unidad --}}
                <div class="flex-1">
                    <label for="quantity_type"
                        class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                        <span class="text-red-600">*</span> Tipo de Unidad
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el tipo de unidad">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                role="tooltip">
                                Indica la unidad de medida (por ejemplo: kg, unidad, caja) en la que se vende el
                                producto.
                            </div>
                        </span>
                    </label>
                    <select id="quantity_type" wire:model="quantity_type"
                        class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white text-base focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="" selected>Selecciona un tipo de unidad</option>
                        @foreach ($quantityTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('quantity_type')
                        <span
                            class="text-sm text-red-500 mt-2 block">{{ str_replace('quantity type', 'tipo de unidad', $message) }}</span>
                    @enderror
                </div>

                {{-- Categoría --}}
                <div class="flex-1">
                    <label for="category_id"
                        class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                        <span class="text-red-600">*</span> Categoría
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre la categoría">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                role="tooltip">
                                Selecciona la categoría que mejor describa el producto para facilitar su búsqueda.
                            </div>
                        </span>
                    </label>
                    <select id="category_id" wire:model="category_id"
                        class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white text-base focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="" selected>Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span
                            class="text-sm text-red-500 mt-2 block">{{ str_replace('category id', 'categoría', $message) }}</span>
                    @enderror
                </div>
            </div>

            {{-- Bancal --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="address_id" class="text-base font-semibold text-gray-800 flex items-center gap-3">
                        <span class="text-red-600">*</span> Bancal de Procedencia
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el bancal de procedencia">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                role="tooltip">
                                Selecciona el bancal o dirección de donde proviene el producto.
                            </div>
                        </span>
                    </label>
                </div>

                <select id="address_id" wire:model="address_id"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white text-base focus:ring-indigo-400 focus:border-indigo-400"
                    @if ($addresses->count() === 0) disabled @endif>
                    <option value="" selected>Selecciona una dirección</option>
                    @foreach ($addresses as $address)
                        <option value="{{ $address->id }}">
                            {{ $address->full_address ?? ($address->name ?? ($address->direccion ?? $address->id)) }}
                        </option>
                    @endforeach
                </select>
                @error('address_id')
                    <span
                        class="text-sm text-red-500 mt-2 block">{{ str_replace('address id', 'bancal', $message) }}</span>
                @enderror
            </div>

            {{-- Imágenes --}}
            <div>
                <label for="images-upload" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                    Imágenes del Producto
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre las imágenes del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Añade imágenes claras y representativas del producto para atraer a más compradores.
                        </div>
                    </span>
                </label>
                <label for="images-upload" class="block w-full cursor-pointer mb-3">
                    <input id="images-upload" type="file" wire:model="newImages" multiple
                        accept="image/png, image/jpeg, image/jpg, image/webp, image/gif" class="hidden" />
                    <span
                        class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-base px-5 py-3 rounded border border-gray-300 hover:bg-indigo-100 transition">
                        Seleccionar imágenes
                    </span>
                </label>
                @error('images.*')
                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                @enderror

                @if ($images && count($images) > 0)
                    <div class="mt-4 flex flex-wrap gap-4" x-data="{
                        dragging: null,
                        dragOver: null,
                        startDrag(index) { this.dragging = index },
                        endDrag() {
                            this.dragging = null;
                            this.dragOver = null
                        },
                        onDrop(index) {
                            if (this.dragging !== null && this.dragging !== index) {
                                $wire.moveImage(this.dragging, index);
                            }
                            this.endDrag();
                        }
                    }">
                        @foreach ($images as $key => $image)
                            @php
                                $imageId = null;
                                if (is_string($image) && isset($product)) {
                                    $imgModel = $product->images->where('path', $image)->first();
                                    $imageId = $imgModel ? $imgModel->id : null;
                                }
                            @endphp
                            <div class="relative group flex items-center justify-center bg-gray-100 border border-indigo-200 rounded shadow"
                                style="width: 180px; height: 180px;" draggable="true"
                                @dragstart="startDrag({{ $key }})" @dragend="endDrag()"
                                @dragover.prevent="dragOver = {{ $key }}" @dragleave="dragOver = null"
                                @drop.prevent="onDrop({{ $key }})"
                                :class="{
                                    'ring-2 ring-indigo-400': dragOver === {{ $key }},
                                    'opacity-60': dragging === {{ $key }}
                                }">
                                @if ($imageId)
                                    <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $imageId]) }}"
                                        class="object-cover w-full h-full rounded" style="width: 100%; height: 100%;"
                                        alt="Imagen del producto {{ $key + 1 }}">
                                @elseif (is_object($image) && method_exists($image, 'temporaryUrl'))
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="object-cover w-full h-full rounded" style="width: 100%; height: 100%;"
                                        alt="Imagen nueva {{ $key + 1 }}">
                                @endif
                                <button type="button" wire:click="removeImage({{ $key }})"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-base font-bold shadow hover:bg-red-700 transition"
                                    title="Quitar imagen {{ $key + 1 }}">
                                    <i class="fas fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Arrastra y suelta las imágenes para reordenarlas.</p>
                @endif
            </div>

            {{-- Permitir fraccionar --}}
            <div x-data="{ fractional: @entangle('allow_fractional') }">
                <label class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    ¿Permitir fraccionar?
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre permitir fraccionar">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Permite que los compradores adquieran cantidades fraccionadas del producto (por ejemplo,
                            medio kilo).
                        </div>
                    </span>
                </label>
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" wire:model="allow_fractional" x-model="fractional"
                        class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150"
                        @if ($allow_fractional) checked @endif>
                    <span class="text-base">Sí</span>
                </label>
                @error('allow_fractional')
                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                @enderror

                <div x-show="fractional" x-transition>
                    <div class="flex flex-col gap-6 sm:flex-row mt-4">
                        <div class="flex-1">
                            <label for="min_per_person"
                                class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                                Mínimo por persona
                                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                                    aria-label="Información sobre el mínimo por persona">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                        role="tooltip">
                                        Cantidad mínima que cada comprador puede adquirir en una sola compra.
                                    </div>
                                </span>
                            </label>
                            <input type="number" id="min_per_person" wire:model="min_per_person" min="0"
                                step="any"
                                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
                            @error('min_per_person')
                                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="max_per_person"
                                class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                                Máximo por persona
                                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                                    aria-label="Información sobre el máximo por persona">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                        role="tooltip">
                                        Cantidad máxima que cada comprador puede adquirir en una sola compra.
                                    </div>
                                </span>
                            </label>
                            <input type="number" id="max_per_person" wire:model="max_per_person" min="0"
                                step="any"
                                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400">
                            @error('max_per_person')
                                <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span> Estado
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el estado del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Indica si el producto está disponible para la venta (activo) o no (inactivo).
                        </div>
                    </span>
                </label>
                <div class="flex items-center gap-12">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="1"
                            class="form-radio w-5 h-5 text-green-600 focus:ring-green-500">
                        <span class="text-base font-bold">Activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="0"
                            class="form-radio w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="text-base font-bold">Inactivo</span>
                    </label>
                </div>
                @error('status')
                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-12">
                <button type="button" @click="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded shadow hover:bg-indigo-700 font-bold text-lg transition"
                    aria-label="{{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}">
                    {{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}
                </button>
                @if ($productId)
                    <div x-data="{ open: false }" class="flex-1">
                        <button type="button" @click="open = true"
                            class="w-full bg-red-600 text-white py-3 px-6 rounded shadow hover:bg-red-700 text-lg font-bold"
                            aria-label="Borrar Producto">
                            Borrar Producto
                        </button>
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                            role="dialog" aria-modal="true">
                            <div class="bg-white rounded shadow p-8 max-w-xs w-full text-center"
                                @click.away="open = false" @keydown.escape.window="open = false">
                                <h2 class="text-lg font-bold mb-4 text-gray-900">¿Seguro que quieres borrar este
                                    producto?</h2>
                                <p class="mb-6 text-gray-600 text-base">Esta acción es irreversible.</p>
                                <div class="flex gap-4 justify-center">
                                    <button type="button" wire:click="delete"
                                        class="bg-red-700 text-white px-6 py-3 rounded hover:bg-red-800 font-semibold text-base">
                                        Sí, borrar
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="bg-gray-200 text-gray-800 px-6 py-3 rounded hover:bg-gray-300 font-semibold text-base">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('private-profile') }}"
                    class="flex-1 flex items-center justify-center gap-3 bg-gray-100 text-gray-700 py-3 px-6 rounded shadow hover:bg-gray-200 font-bold text-lg transition border border-gray-300"
                    aria-label="Cancelar y volver al perfil privado">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div>
