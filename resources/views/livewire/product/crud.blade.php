@section('title', $productId ? 'Editar Producto' : 'Crear Producto')

<div x-data="{
    submit() { $wire.save() }
}" class="max-w-3xl mx-auto p-10 my-14 bg-white shadow rounded border border-gray-200"
    role="form" aria-labelledby="product-form-title">
    <h1 id="product-form-title" class="text-3xl font-bold text-indigo-700 mb-10 text-center">
        {{ $productId ? 'Editar Producto' : 'Crear Producto' }}
    </h1>
    <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">
        {{-- Nombre --}}
        <div class="mb-6">
            <label for="name" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
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
                class="mt-2 block w-64 border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true" aria-describedby="name-desc @error('name') name-error @enderror">
            <span id="name-desc" class="sr-only">Nombre público del producto</span>
            @error('name')
                <span id="name-error" class="text-sm text-red-500 mt-2 block" role="alert">
                    {{ str_replace('name', 'nombre', $message) }}
                </span>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-6">
            <label for="description" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                Descripción
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre la descripción">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Escribe una descripción clara y detallada del producto para ayudar a los compradores a entender
                        sus características y beneficios.
                    </div>
                </span>
            </label>
            <textarea id="description" wire:model="description"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 resize-none min-h-[90px] focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true" aria-describedby="description-desc @error('description') description-error @enderror"></textarea>
            <span id="description-desc" class="sr-only">Descripción detallada del producto</span>
            @error('description')
                <span id="description-error" class="text-sm text-red-500 mt-2 block"
                    role="alert">{{ $message }}</span>
            @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-6">
            <label for="price" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Precio (€)
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre el precio">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Ingresa el precio por unidad del producto. Usa punto para decimales, por ejemplo: 12.50
                    </div>
                </span>
            </label>
            <input type="number" id="price" wire:model="price" min="0" step="0.01"
                class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" aria-required="true"
                aria-describedby="price-desc @error('price') price-error @enderror">
            <span id="price-desc" class="sr-only">Precio por unidad, usa punto para decimales</span>
            @error('price')
                <span id="price-error" class="text-sm text-red-500 mt-2 block" role="alert">
                    {{ str_replace('price', 'precio', $message) }}
                </span>
            @else
                @if (!is_numeric($price) && $price !== null && $price !== '')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">Solo números</span>
                @endif
            @enderror
        </div>

        {{-- Cantidad --}}
        <div class="mb-6">
            <label for="quantity" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Cantidad
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre la cantidad">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Ingresa la cantidad total disponible para la venta. Solo números enteros.
                    </div>
                </span>
            </label>
            <input type="number" id="quantity" wire:model="quantity" min="0" step="1"
                class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" aria-required="true"
                aria-describedby="quantity-desc @error('quantity') quantity-error @enderror">
            <span id="quantity-desc" class="sr-only">Cantidad total disponible, solo números enteros</span>
            @error('quantity')
                <span id="quantity-error" class="text-sm text-red-500 mt-2 block"
                    role="alert">{{ str_replace('quantity', 'cantidad', $message) }}</span>
            @else
                @if (!is_numeric($quantity) && $quantity !== null && $quantity !== '')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">Solo números</span>
                @endif
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-8">
            <label for="category_id" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Categoría
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre la categoría">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Elige la categoría que mejor describa tu producto. Esto ayudará a los compradores a encontrarlo
                        más fácilmente.
                    </div>
                </span>
            </label>
            <select id="category_id" wire:model="category_id"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true" aria-describedby="category-desc @error('category_id') category-error @enderror">
                <option value="" selected>Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <span id="category-desc" class="sr-only">Selecciona la categoría del producto</span>
            @error('category_id')
                <span id="category-error" class="text-sm text-red-500 mt-2 block"
                    role="alert">{{ str_replace('category id', 'categoría', $message) }}</span>
            @enderror
        </div>

        {{-- Tipo de Unidad --}}
        <div class="mb-6">
            <label for="quantity_type"
                class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Tipo de Unidad
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre el tipo de unidad">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Elige el tipo de unidad que corresponde a la cantidad del producto, por ejemplo: kilos, litros,
                        unidades, etc.
                    </div>
                </span>
            </label>
            <select id="quantity_type" wire:model="quantity_type"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true"
                aria-describedby="quantity-type-desc @error('quantity_type') quantity-type-error @enderror">
                <option value="" selected>Selecciona un tipo de unidad</option>
                @foreach ($quantityTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            <span id="quantity-type-desc" class="sr-only">Selecciona el tipo de unidad</span>
            @error('quantity_type')
                <span id="quantity-type-error" class="text-sm text-red-500 mt-2 block"
                    role="alert">{{ str_replace('quantity type', 'tipo de unidad', $message) }}</span>
            @enderror
        </div>

        {{-- Imágenes --}}
        <div class="mb-8" x-data="{ dragIndex: null }">
            <label for="images-upload"
                class="block text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                Imágenes del Producto
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre las imágenes">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Sube imágenes claras y de buena calidad para mostrar tu producto. Puedes arrastrar para
                        reordenar. Elige archivos JPG, PNG o WebP.
                    </div>
                </span>
            </label>
            <label for="images-upload" class="block w-full cursor-pointer mb-3"
                aria-label="Seleccionar imágenes del producto">
                <input id="images-upload" type="file" wire:model="newImages" multiple accept="image/*"
                    class="hidden" aria-describedby="images-desc @error('images.*') images-error @enderror" />
                <span
                    class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-sm px-5 py-3 rounded border border-gray-300 hover:bg-indigo-100 transition">
                    <i class="fas fa-images mr-2" aria-hidden="true"></i> Seleccionar imágenes
                </span>
            </label>
            <span id="images-desc" class="sr-only">Sube imágenes del producto. Puedes arrastrar para reordenar.</span>
            @error('images.*')
                <span id="images-error" class="text-sm text-red-500 mt-2 block"
                    role="alert">{{ $message }}</span>
            @enderror

            @if ($images && count($images) > 0)
                <div class="mt-5 flex flex-wrap gap-6" aria-label="Vista previa de imágenes">
                    @foreach ($images as $key => $image)
                        @php
                            // Si es string, es una imagen ya guardada (ruta en DB)
                            $imageId = null;
                            if (is_string($image) && isset($product)) {
                                $imgModel = $product->images->where('path', $image)->first();
                                $imageId = $imgModel ? $imgModel->id : null;
                            }
                        @endphp
                        <div class="relative group" draggable="true" @dragstart="dragIndex = {{ $key }}"
                            @dragover.prevent
                            @drop="$wire.moveImage(dragIndex, {{ $key }}); dragIndex = null"
                            :class="{ 'ring-2 ring-indigo-400': dragIndex === {{ $key }} }"
                            aria-label="Imagen {{ $key + 1 }}">
                            @if ($imageId)
                                <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $imageId]) }}"
                                    class="w-48 h-48 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Imagen del producto {{ $key + 1 }}">
                            @elseif (is_object($image) && method_exists($image, 'temporaryUrl'))
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-48 h-48 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Imagen nueva {{ $key + 1 }}">
                            @endif
                            <button type="button" wire:click="removeImage({{ $key }})"
                                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold shadow hover:bg-red-700 transition z-20"
                                title="Quitar imagen {{ $key + 1 }}"
                                aria-label="Quitar imagen {{ $key + 1 }}">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Permitir fraccionar --}}
        <div class="mb-6" x-data="{ fractional: @entangle('allow_fractional') }">
            <label class="block text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                ¿Permitir fraccionar?
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre permitir fraccionar">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        Activa esta opción si deseas que los compradores puedan adquirir cantidades fraccionadas del
                        producto (por ejemplo, 0.5 kg, 1.25 litros, etc.).
                    </div>
                </span>
            </label>
            <label class="inline-flex items-center gap-3">
                <input type="checkbox" wire:model="allow_fractional" x-model="fractional"
                    class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150"
                    @if ($allow_fractional) checked @endif
                    aria-checked="{{ $allow_fractional ? 'true' : 'false' }}" aria-label="Permitir fraccionar">
                <span class="text-base">Sí</span>
            </label>
            @error('allow_fractional')
                <span class="text-sm text-red-500 mt-2 block" role="alert">{{ $message }}</span>
            @enderror

            <div x-show="fractional" x-transition>
                {{-- Mínimo por persona --}}
                <div class="mt-6">
                    <label for="min_per_person"
                        class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        Mínimo por persona
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el mínimo por persona">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Define la cantidad mínima que una persona puede comprar de este producto.
                            </div>
                        </span>
                    </label>
                    <input type="number" id="min_per_person" wire:model="min_per_person" min="0"
                        step="any"
                        class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                        aria-describedby="min-per-person-desc @error('min_per_person') min-per-person-error @enderror">
                    <span id="min-per-person-desc" class="sr-only">Cantidad mínima por persona</span>
                    @error('min_per_person')
                        <span id="min-per-person-error" class="text-sm text-red-500 mt-2 block"
                            role="alert">{{ $message }}</span>
                    @else
                        @if (!is_numeric($min_per_person) && $min_per_person !== null && $min_per_person !== '')
                            <span class="text-sm text-red-500 mt-2 block" role="alert">Solo números</span>
                        @endif
                    @enderror
                </div>

                {{-- Máximo por persona --}}
                <div class="mt-6">
                    <label for="max_per_person"
                        class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        Máximo por persona
                        <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                            aria-label="Información sobre el máximo por persona">
                            <i class="fas fa-info-circle" aria-hidden="true"></i>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                                role="tooltip">
                                Define la cantidad máxima que una persona puede comprar de este producto.
                            </div>
                        </span>
                    </label>
                    <input type="number" id="max_per_person" wire:model="max_per_person" min="0"
                        step="any"
                        class="mt-2 block w-48 border border-gray-300 rounded px-5 py-3 text-base focus:ring-indigo-400 focus:border-indigo-400"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                        aria-describedby="max-per-person-desc @error('max_per_person') max-per-person-error @enderror">
                    <span id="max-per-person-desc" class="sr-only">Cantidad máxima por persona</span>
                    @error('max_per_person')
                        <span id="max-per-person-error" class="text-sm text-red-500 mt-2 block"
                            role="alert">{{ $message }}</span>
                    @else
                        @if (!is_numeric($max_per_person) && $max_per_person !== null && $max_per_person !== '')
                            <span class="text-sm text-red-500 mt-2 block" role="alert">Solo números</span>
                        @endif
                    @enderror
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="mb-8">
            <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Estado
                <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                    aria-label="Información sobre el estado">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-4 py-2 text-sm text-gray-700 w-64"
                        role="tooltip">
                        El estado determina si el producto está disponible para la venta (Activo) o no visible para los
                        compradores (Inactivo).
                    </div>
                </span>
            </label>
            <div class="flex items-center gap-16" role="radiogroup" aria-label="Estado del producto">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="1"
                        class="form-radio w-6 h-6 text-green-600 focus:ring-green-500 transition-all duration-150"
                        aria-checked="{{ $status == 1 ? 'true' : 'false' }}" aria-label="Activo" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-green-700 transition">
                        Activo
                    </span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="0"
                        class="form-radio w-6 h-6 text-red-600 focus:ring-red-500 transition-all duration-150"
                        aria-checked="{{ $status == 0 ? 'true' : 'false' }}" aria-label="Inactivo" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-red-700 transition">
                        Inactivo
                    </span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-2 block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-6 mt-12">
            <button type="button" @click="submit"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-4 px-8 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-600 font-bold text-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2"
                aria-label="{{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}">
                <i class="fas fa-save mr-2" aria-hidden="true"></i>
                {{ $productId ? 'Actualizar Producto' : 'Crear Producto' }}
            </button>
            @if ($productId)
                <div x-data="{ open: false }" class="flex-1">
                    <button type="button" @click="open = true"
                        class="w-full bg-red-600 text-white py-4 px-8 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                        style="z-index:1;" aria-label="Borrar Producto">
                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Borrar Producto
                    </button>
                    <!-- Modal de confirmación -->
                    <div x-show="open" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                        role="dialog" aria-modal="true" aria-labelledby="modal-title">
                        <div class="bg-white rounded-xl shadow-lg p-10 max-w-sm w-full text-center"
                            @click.away="open = false" @keydown.escape.window="open = false">
                            <h2 id="modal-title" class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres
                                borrar este producto?
                            </h2>
                            <p class="mb-8 text-gray-600">Esta acción es irreversible y no podrás recuperarlo.</p>
                            <div class="flex gap-6 justify-center">
                                <button type="button" wire:click="delete"
                                    class="inline-flex items-center bg-red-700 text-white px-8 py-4 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base"
                                    aria-label="Confirmar borrado">
                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Sí, borrar
                                </button>
                                <button type="button" @click="open = false"
                                    class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold"
                                    aria-label="Cancelar borrado">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <a href="{{ route('private-profile') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 py-4 px-8 rounded-lg shadow-lg hover:from-gray-300 hover:to-gray-400 font-bold text-lg transition-all duration-200 text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 border border-gray-300"
                aria-label="Cancelar y volver al perfil privado">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 mr-2">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                </span>
                Cancelar
            </a>
        </div>
    </div>
</div>
