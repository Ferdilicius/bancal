<div class="relative w-full" x-data">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fas fa-search text-[#9E203F] text-lg"></i>
    </span>
    <input type="text" wire:model.live="searchTerm" placeholder="EXPLORAR BANCALES"
        class="w-full h-9 md:h-11 pl-10 pr-3 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-sm md:text-base transition-all" />

    @if ($showResults && strlen($searchTerm) >= 1)
        <div class="absolute left-0 right-0 mt-3 bg-white border rounded-2xl shadow-2xl z-20 overflow-hidden w-full">
            @forelse($results as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="flex flex-col sm:flex-row items-center justify-between p-4 sm:p-6 border-b last:border-b-0 hover:bg-[#fbeaf0] transition rounded-xl gap-4 sm:gap-6 group">
                    @php
                        $image = $product->images->first();
                    @endphp

                    <div class="flex items-center gap-4 sm:gap-6 min-w-0 w-full sm:w-auto">
                        <div class="flex-shrink-0">
                            @if ($image && \Illuminate\Support\Facades\Storage::disk('local')->exists($image->path))
                                <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $image->id]) }}" alt="Imagen del producto"
                                    class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 object-cover rounded-lg border-2 border-[#9E203F]/20 shadow-sm group-hover:scale-105 transition" />
                            @else
                                <div
                                    class="flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 bg-gray-100 rounded-lg border-2 border-gray-200 text-gray-400 text-base font-semibold text-center">
                                    <span class="w-full">Sin imagen</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center min-w-0 w-full">
                            <div class="font-bold text-[#9E203F] leading-tight text-lg sm:text-xl truncate">
                                {{ $product->name }}
                            </div>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="bg-[#fbeaf0] text-[#9E203F] font-semibold px-3 py-1.5 rounded text-sm">
                                    {{ $product->formatted_quantity ?? '' }}
                                </span>
                                <span class="bg-[#9E203F] text-white font-bold px-3 py-1.5 rounded text-sm">
                                    €{{ number_format($product->price, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end ml-0 sm:ml-6 min-w-0 w-full sm:w-[140px] mt-3 sm:mt-0">
                        <span class="text-sm text-gray-400">User</span>
                        <span class="font-semibold text-[#9E203F] text-base truncate">
                            {{ $product->user->name ?? 'Desconocido' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="p-6 text-gray-500 text-lg text-center">No se encontraron productos.</div>
            @endforelse
        </div>
    @endif
</div>
