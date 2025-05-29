<div class="relative w-full">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fas fa-search text-[#9E203F] text-lg"></i>
    </span>
    <input type="text" wire:model.debounce.300ms="searchTerm" placeholder="EXPLORAR BANCALES"
        class="w-full h-10 md:h-12 px-4 pl-10 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-base md:text-lg transition-all" />

    @if (strlen($searchTerm) > 1)
        <div class="absolute left-0 right-0 mt-2 bg-white border rounded-lg shadow-lg z-10">
            @forelse($results as $product)
                <div class="flex items-center p-2 border-b last:border-b-0">

                    {{-- Ajusta esto según cómo guardes tus imágenes --}}
                    <x-product-image :product="$product" class="w-16 h-16 mr-3 rounded-lg object-cover" />
                    <div>
                        <div class="font-bold text-[#9E203F]">{{ $product->name }}</div>
                        <div class="text-sm text-gray-600">Cantidad: {{ $product->quantity }}</div>
                        <div class="text-sm text-gray-600">Precio: €{{ $product->price }}</div>
                    </div>
                </div>
            @empty
                <div class="p-2 text-gray-500">No se encontraron productos.</div>
            @endforelse
        </div>
    @endif
</div>
