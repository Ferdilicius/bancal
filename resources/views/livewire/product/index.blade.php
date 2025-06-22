@section('title', 'Todos los Productos')

<div class="p-6 bg-gray-100">
    <div>
        <!-- Filtros para escritorio -->
        <div
            class="hidden sm:flex bg-white rounded-lg shadow-md p-3 sm:p-4 mb-4 sm:mb-6 flex-row gap-2 sm:gap-4 items-end text-xs sm:text-base">
            <div class="flex-1 min-w-[110px] sm:min-w-[180px]">
                <label class="block text-[10px] sm:text-xs font-semibold text-gray-700 mb-1">Categoría</label>
                <select wire:model="category_id"
                    class="w-full border-gray-300 rounded px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-base">
                    <option value="">Todas</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[110px] sm:min-w-[180px]">
                <label class="block text-[10px] sm:text-xs font-semibold text-gray-700 mb-1">Tipo</label>
                <select wire:model="quantity_type"
                    class="w-full border-gray-300 rounded px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-base">
                    <option value="">Todos</option>
                    <option value="gramo">Gramo</option>
                    <option value="kilo">Kilo</option>
                    <option value="litro">Litro</option>
                    <option value="unidad">Unidad</option>
                    <option value="bolsa">Bolsa</option>
                    <option value="caja">Caja</option>
                </select>
            </div>
            <div class="flex-1 min-w-[110px] sm:min-w-[180px]">
                <label class="block text-[10px] sm:text-xs font-semibold text-gray-700 mb-1">Ordenar por</label>
                <select wire:model="orderBy"
                    class="w-full border-gray-300 rounded px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-base">
                    <option value="created_at_desc">Más recientes</option>
                    <option value="created_at_asc">Más antiguos</option>
                    <option value="price_asc">Precio: menor a mayor</option>
                    <option value="price_desc">Precio: mayor a menor</option>
                    <option value="name_asc">Nombre A-Z</option>
                    <option value="name_desc">Nombre Z-A</option>
                </select>
            </div>
            <button wire:click="resetFilters"
                class="bg-gray-200 text-gray-700 px-2 py-1 sm:px-4 sm:py-2 rounded font-semibold hover:bg-gray-300 transition min-w-[70px] sm:min-w-[120px] text-xs sm:text-base">
                Limpiar
            </button>
        </div>

        <!-- Botón de filtros para móvil -->
        <div class="flex sm:hidden mb-4">
            <button x-data @click="$dispatch('open-modal', { id: 'mobile-filters' })"
                class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-2 shadow font-semibold text-gray-700 w-full justify-center">
                <i class="fas fa-filter"></i> Filtros
            </button>
        </div>

        <!-- Modal de filtros para móvil -->
        <div x-data="{ open: false }" x-on:open-modal.window="if ($event.detail.id === 'mobile-filters') open = true"
            x-show="open" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-sm p-6 relative">
                <button @click="open = false"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                <h2 class="text-lg font-bold mb-4 text-gray-800">Filtros</h2>
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Categoría</label>
                    <select wire:model="category_id" class="w-full border-gray-300 rounded px-2 py-2 text-base">
                        <option value="">Todas</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Tipo</label>
                    <select wire:model="quantity_type" class="w-full border-gray-300 rounded px-2 py-2 text-base">
                        <option value="">Todos</option>
                        <option value="gramo">Gramo</option>
                        <option value="kilo">Kilo</option>
                        <option value="litro">Litro</option>
                        <option value="unidad">Unidad</option>
                        <option value="bolsa">Bolsa</option>
                        <option value="caja">Caja</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Ordenar por</label>
                    <select wire:model="orderBy" class="w-full border-gray-300 rounded px-2 py-2 text-base">
                        <option value="created_at_desc">Más recientes</option>
                        <option value="created_at_asc">Más antiguos</option>
                        <option value="price_asc">Precio: menor a mayor</option>
                        <option value="price_desc">Precio: mayor a menor</option>
                        <option value="name_asc">Nombre A-Z</option>
                        <option value="name_desc">Nombre Z-A</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button
                        wire:click="$set('category_id', ''); $set('quantity_type', ''); $set('orderBy', 'created_at_desc');"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold hover:bg-gray-300 transition w-1/2">
                        Limpiar
                    </button>
                    <button @click="open = false"
                        class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 transition w-1/2">
                        Aplicar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($products->count())
        <!-- Productos -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="bg-white border border-gray-200 rounded-lg shadow-md p-3 sm:p-4 hover:shadow-lg transition-shadow duration-200 flex flex-col">
                    @php
                        $firstImage = $product->images->first();
                    @endphp
                    @if ($firstImage)
                        <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $firstImage->id]) }}"
                            alt="Imagen producto"
                            class="w-full h-28 sm:h-32 object-cover rounded-t-lg mb-2 transition-transform duration-200 hover:scale-105">
                    @else
                        <div
                            class="w-full h-28 sm:h-32 bg-gray-300 flex items-center justify-center rounded-t-lg mb-2 text-gray-500">
                            Sin imagen
                        </div>
                    @endif

                    <div class="flex items-center mt-1 mb-1">
                        <img src="{{ $product->user ? $product->user->profile_photo_url : 'https://ui-avatars.com/api/?name=Vendedor+desconocido&background=cccccc&color=555555&size=64' }}"
                            alt="{{ $product->user->name ?? 'Vendedor desconocido' }}"
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full mr-2 border border-gray-300">
                        <span
                            class="text-gray-700 text-xs sm:text-sm">{{ $product->user->name ?? 'Vendedor desconocido' }}</span>
                    </div>

                    <h2 class="text-base sm:text-lg font-bold text-gray-800 mb-1 truncate">{{ $product->name }}</h2>
                    <p class="text-gray-700 font-semibold mb-1 text-sm sm:text-base">Cantidad:
                        {{ $product->formatted_quantity }}</p>
                    <p class="text-gray-700 font-semibold text-sm sm:text-base">Precio:
                        {{ $product->price }}€</p>
                </a>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            <div class="bg-white p-4 rounded-lg shadow-md">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center min-h-[40vh] sm:min-h-[60vh]">
            <i class="fas fa-search text-5xl sm:text-6xl text-gray-300 mb-4 sm:mb-6"></i>
            <p class="text-gray-500 text-center text-lg sm:text-xl font-semibold mb-1 sm:mb-2">
                No existen productos que coincidan con tu búsqueda
            </p>
            <p class="text-gray-400 text-center mb-2 sm:mb-4">
                Intenta modificar los filtros o la búsqueda para ver otros productos.
            </p>
        </div>
    @endif
</div>
