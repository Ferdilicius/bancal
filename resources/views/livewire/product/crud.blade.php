@section('title', $productId ? 'Editar Producto' : 'Crear Producto')

<div class="max-w-5xl mx-auto py-10 px-4 sm:px-8">
    <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div x-data="{
        submit() { $wire.save() }
    }" class="mx-auto p-8 bg-white shadow rounded border border-gray-200" role="form"
        aria-labelledby="product-form-title">

        <h1 id="product-form-title" class="text-xl font-bold text-indigo-700 mb-6 text-center">
            {{ $productId ? 'Editar Producto' : 'Crear Producto' }}
        </h1>
        <div class="space-y-6" enctype="multipart/form-data" @keydown.enter.prevent="submit">

            {{-- Nombre --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    <span class="text-red-600">*</span>
                    Nombre
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el nombre del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                            role="tooltip">
                            Este es el nombre público del producto. Usa un nombre claro y reconocible para que los
                            compradores lo encuentren fácilmente.
                        </div>
                    </span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 focus:ring-indigo-400 focus:border-indigo-400 text-sm"
                    aria-required="true">
                @error('name')
                    <span class="text-xs text-red-500 mt-1 block">{{ str_replace('name', 'nombre', $message) }}</span>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    Descripción
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre la descripción del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                            role="tooltip">
                            Describe brevemente el producto, sus características, usos o cualquier información relevante
                            para el comprador.
                        </div>
                    </span>
                </label>
                <textarea id="description" wire:model="description"
                    class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 resize-none min-h-[70px] focus:ring-indigo-400 focus:border-indigo-400 text-sm"></textarea>
                @error('description')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Precio y Cantidad --}}
            <div class="flex flex-col gap-4 sm:flex-row">
                <div class="flex-1">
                    <label for="price" class="flex text-sm font-semibold text-gray-800 mb-1 items-center gap-2">
                        <span class="text-red-600">*</span> Precio (€)
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el precio">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Indica el precio de venta del producto en euros. Usa punto para decimales.
                            </div>
                        </span>
                    </label>
                    <input type="text" id="price" wire:model="price"
                        class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-400"
                        inputmode="decimal" pattern="^\d+(\.\d{0,2})?$"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^(\d*\.\d{0,2}).*$/, '$1')">
                    @error('price')
                        <span class="text-xs text-red-500 mt-1 block">{{ str_replace('price', 'precio', $message) }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="quantity" class="flex text-sm font-semibold text-gray-800 mb-1 items-center gap-2">
                        <span class="text-red-600">*</span> Cantidad
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre la cantidad">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Especifica la cantidad total disponible para la venta. Solo números enteros.
                            </div>
                        </span>
                    </label>
                    <input type="text" id="quantity" wire:model="quantity"
                        class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-400"
                        inputmode="numeric" pattern="^\d*$" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('quantity')
                        <span
                            class="text-xs text-red-500 mt-1 block">{{ str_replace('quantity', 'cantidad', $message) }}</span>
                    @enderror
                </div>
            </div>

            {{-- Tipo de Unidad y Categoría --}}
            <div class="flex flex-col gap-4 sm:flex-row">
                {{-- Tipo de Unidad --}}
                <div class="flex-1">
                    <label for="quantity_type" class="flex text-sm font-semibold text-gray-800 mb-1 items-center gap-2">
                        <span class="text-red-600">*</span> Tipo de Unidad
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el tipo de unidad">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Indica la unidad de medida (por ejemplo: kg, unidad, caja) en la que se vende el
                                producto.
                            </div>
                        </span>
                    </label>
                    <select id="quantity_type" wire:model="quantity_type"
                        class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 bg-white text-sm focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="" selected>Selecciona un tipo de unidad</option>
                        @foreach ($quantityTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('quantity_type')
                        <span
                            class="text-xs text-red-500 mt-1 block">{{ str_replace('quantity type', 'tipo de unidad', $message) }}</span>
                    @enderror
                </div>

                {{-- Categoría --}}
                <div class="flex-1">
                    <label for="category_id"
                        class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                        <span class="text-red-600">*</span> Categoría
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre la categoría">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Selecciona la categoría que mejor describa el producto para facilitar su búsqueda.
                            </div>
                        </span>
                    </label>
                    <select id="category_id" wire:model="category_id"
                        class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 bg-white text-sm focus:ring-indigo-400 focus:border-indigo-400">
                        <option value="" selected>Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span
                            class="text-xs text-red-500 mt-1 block">{{ str_replace('category id', 'categoría', $message) }}</span>
                    @enderror
                </div>
            </div>

            {{-- Bancal --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="address_id" class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <span class="text-red-600">*</span> Bancal de Procedencia
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el bancal de procedencia">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Selecciona el bancal o dirección de donde proviene el producto.
                            </div>
                        </span>
                    </label>
                </div>

                <select id="address_id" wire:model="address_id"
                    class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 bg-white text-sm focus:ring-indigo-400 focus:border-indigo-400"
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
                        class="text-xs text-red-500 mt-1 block">{{ str_replace('address id', 'dirección', $message) }}</span>
                @enderror
            </div>

            {{-- Imágenes --}}
            <div>
                <label for="images-upload"
                    class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    Imágenes del Producto
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre las imágenes del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                            role="tooltip">
                            Añade imágenes claras y representativas del producto para atraer a más compradores.
                        </div>
                    </span>
                </label>
                <label for="images-upload" class="block w-full cursor-pointer mb-2">
                    <input id="images-upload" type="file" wire:model="newImages" multiple accept="image/*"
                        class="hidden" />
                    <span
                        class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-xs px-4 py-2 rounded border border-gray-300 hover:bg-indigo-100 transition">
                        Seleccionar imágenes
                    </span>
                </label>
                @error('images.*')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror

                @if ($images && count($images) > 0)
                    <div class="mt-3 flex flex-wrap gap-3">
                        @foreach ($images as $key => $image)
                            @php
                                $imageId = null;
                                if (is_string($image) && isset($product)) {
                                    $imgModel = $product->images->where('path', $image)->first();
                                    $imageId = $imgModel ? $imgModel->id : null;
                                }
                            @endphp
                            <div class="relative group" style="width: 80px; height: 80px;">
                                @if ($imageId)
                                    <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $imageId]) }}"
                                        class="w-20 h-20 object-cover rounded border border-indigo-200 shadow"
                                        alt="Imagen del producto {{ $key + 1 }}">
                                @elseif (is_object($image) && method_exists($image, 'temporaryUrl'))
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="w-20 h-20 object-cover rounded border border-indigo-200 shadow"
                                        alt="Imagen nueva {{ $key + 1 }}">
                                @endif
                                <button type="button" wire:click="removeImage({{ $key }})"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold shadow hover:bg-red-700 transition"
                                    title="Quitar imagen {{ $key + 1 }}">
                                    <i class="fas fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Permitir fraccionar --}}
            <div x-data="{ fractional: @entangle('allow_fractional') }">
                <label class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    ¿Permitir fraccionar?
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre permitir fraccionar">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                            role="tooltip">
                            Permite que los compradores adquieran cantidades fraccionadas del producto (por ejemplo,
                            medio kilo).
                        </div>
                    </span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="allow_fractional" x-model="fractional"
                        class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150"
                        @if ($allow_fractional) checked @endif>
                    <span class="text-sm">Sí</span>
                </label>
                @error('allow_fractional')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror

                <div x-show="fractional" x-transition>
                    <div class="flex flex-col gap-4 sm:flex-row mt-3">
                        <div class="flex-1">
                            <label for="min_per_person"
                                class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                                Mínimo por persona
                                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                                    aria-label="Información sobre el mínimo por persona">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                        role="tooltip">
                                        Cantidad mínima que cada comprador puede adquirir en una sola compra.
                                    </div>
                                </span>
                            </label>
                            <input type="number" id="min_per_person" wire:model="min_per_person" min="0"
                                step="any"
                                class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-400">
                            @error('min_per_person')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="max_per_person"
                                class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                                Máximo por persona
                                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                                    aria-label="Información sobre el máximo por persona">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                        role="tooltip">
                                        Cantidad máxima que cada comprador puede adquirir en una sola compra.
                                    </div>
                                </span>
                            </label>
                            <input type="number" id="max_per_person" wire:model="max_per_person" min="0"
                                step="any"
                                class="mt-1 block w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-400">
                            @error('max_per_person')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    <span class="text-red-600">*</span> Estado
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el estado del producto">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                            role="tooltip">
                            Indica si el producto está disponible para la venta (activo) o no (inactivo).
                        </div>
                    </span>
                </label>
                <div class="flex items-center gap-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="status" value="1"
                            class="form-radio w-4 h-4 text-green-600 focus:ring-green-500">
                        <span class="text-sm font-bold">Activo</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="status" value="0"
                            class="form-radio w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-bold">Inactivo</span>
                    </label>
                </div>
                @error('status')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex flex-col sm:flex-row gap-3 mt-8">
                <button type="button" @click="submit"
                    class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded shadow hover:bg-indigo-700 font-bold text-base transition"
                    aria-label="{{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}">
                    {{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}
                </button>
                @if ($productId)
                    <div x-data="{ open: false }" class="flex-1">
                        <button type="button" @click="open = true"
                            class="w-full bg-red-600 text-white py-2 px-4 rounded shadow hover:bg-red-700 text-base font-bold"
                            aria-label="Borrar Producto">
                            Borrar Producto
                        </button>
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                            role="dialog" aria-modal="true">
                            <div class="bg-white rounded shadow p-6 max-w-xs w-full text-center"
                                @click.away="open = false" @keydown.escape.window="open = false">
                                <h2 class="text-base font-bold mb-3 text-gray-900">¿Seguro que quieres borrar este
                                    producto?</h2>
                                <p class="mb-5 text-gray-600 text-sm">Esta acción es irreversible.</p>
                                <div class="flex gap-3 justify-center">
                                    <button type="button" wire:click="delete"
                                        class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800 font-semibold text-sm">
                                        Sí, borrar
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 font-semibold text-sm">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('private-profile') }}"
                    class="flex-1 flex items-center justify-center gap-2 bg-gray-100 text-gray-700 py-2 px-4 rounded shadow hover:bg-gray-200 font-bold text-base transition border border-gray-300"
                    aria-label="Cancelar y volver al perfil privado">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div>
