<div class="relative w-full" x-data="{ open: false }" @click.away="open = false">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fas fa-search text-[#9E203F] text-lg"></i>
    </span>
    <input type="text" wire:model.live="searchTerm" placeholder="EXPLORAR BANCALES"
        class="w-full h-9 md:h-11 pl-10 pr-3 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-sm md:text-base transition-all"
        @focus="open = true" @input="open = true" />

    @if ($showResults && strlen($searchTerm) >= 1)
        <div x-show="open" x-transition
            class="absolute left-0 right-0 mt-2 bg-white border rounded-2xl shadow-2xl z-20 overflow-hidden w-full max-h-[70vh] overflow-y-auto">
            @forelse($results as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="flex flex-col sm:flex-row items-center sm:items-start justify-between p-3 sm:p-6 border-b last:border-b-0 hover:bg-[#fbeaf0] transition rounded-xl gap-3 sm:gap-6 group">
                    @php
                        $image = $product->images->first();
                        $user = $product->user;
                    @endphp

                    <div class="flex items-center gap-3 sm:gap-6 min-w-0 w-full sm:w-auto">
                        <div class="flex-shrink-0">
                            @if ($image && \Illuminate\Support\Facades\Storage::disk('local')->exists($image->path))
                                <img src="{{ route('product.image', ['productId' => $product->id, 'imageId' => $image->id]) }}"
                                    alt="Imagen del producto"
                                    class="w-14 h-14 sm:w-24 sm:h-24 md:w-28 md:h-28 object-cover rounded-lg border-2 border-[#9E203F]/20 shadow-sm group-hover:scale-105 transition" />
                            @else
                                <div
                                    class="flex items-center justify-center w-14 h-14 sm:w-24 sm:h-24 md:w-28 md:h-28 bg-gray-100 rounded-lg border-2 border-gray-200 text-gray-400 text-xs sm:text-base font-semibold text-center">
                                    <span class="w-full">Sin imagen</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center min-w-0 w-full">
                            <div class="font-bold text-[#9E203F] leading-tight text-sm sm:text-lg md:text-xl truncate">
                                {{ $product->name }}
                            </div>
                            <div class="flex flex-wrap items-center gap-1 sm:gap-3 mt-2">
                                <span
                                    class="bg-[#fbeaf0] text-[#9E203F] font-semibold px-2 py-0.5 sm:px-3 sm:py-1.5 rounded text-xs sm:text-sm">
                                    {{ $product->formatted_quantity ?? '' }}
                                </span>
                                <span
                                    class="bg-[#9E203F] text-white font-bold px-2 py-0.5 sm:px-3 sm:py-1.5 rounded text-xs sm:text-sm">
                                    €{{ number_format($product->price, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-row sm:flex-col items-center sm:items-end ml-0 sm:ml-6 min-w-0 w-full sm:w-[140px] mt-2 sm:mt-0 gap-2 sm:gap-1">
                        <img src="{{ $product->user->profile_photo_url }}" alt="Foto de perfil"
                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 text-gray-500 object-cover shadow-sm" />
                        <div class="flex flex-col items-start sm:items-end">
                            <span class="text-xs sm:text-sm text-gray-400">User</span>
                            <span class="font-semibold  text-gray-500" text-xs sm:text-base truncate">
                                {{ $user->name ?? 'Desconocido' }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-4 sm:p-6 text-gray-500 text-sm sm:text-lg text-center">No se encontraron productos.</div>
            @endforelse
        </div>
    @endif
</div>
