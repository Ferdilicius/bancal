<div class="relative w-full" x-data x-on:click.away="$wire.set('searchTerm', '')">

    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fas fa-search text-[#9E203F] text-lg"></i>
    </span>

    <input type="text" wire:model.live="searchTerm" placeholder="EXPLORAR BANCALES"
        class="w-full h-10 md:h-12 pl-10 bg-white text-[#9E203F] rounded-full placeholder-[#9E203F] focus:outline-none focus:ring-2 focus:ring-[#9E203F] font-semibold text-base md:text-lg transition-all" />

    @if (strlen($searchTerm) >= 1)
        <div class="absolute left-0 right-0 mt-3 bg-white border rounded-2xl shadow-2xl z-20 overflow-hidden">
            @forelse($results as $product)
                <a href="{{ route('product.show', $product->id) }}"
                    class="flex items-center justify-between p-4 border-b last:border-b-0 hover:bg-[#fbeaf0] transition rounded-xl gap-5 group">
                    @php
                        $image = $product->images->first();
                    @endphp

                    <div class="flex items-center gap-4 min-w-0">
                        <div class="flex-shrink-0">
                            @if ($image && \Illuminate\Support\Facades\Storage::disk('public')->exists($image->path))
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Imagen del producto"
                                    class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border-2 border-[#9E203F]/20 shadow-sm group-hover:scale-105 transition" />
                            @else
                                <div
                                    class="flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gray-100 rounded-lg border-2 border-gray-200 text-gray-400 text-base font-semibold text-center">
                                    <span class="w-full">Sin imagen</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center min-w-0">
                            <div class="font-bold text-[#9E203F] leading-tight text-lg truncate">{{ $product->name }}
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="bg-[#fbeaf0] text-[#9E203F] font-semibold px-2 py-1 rounded text-xs">
                                    {{ $product->quantity }} {{ $product->quantity_type ?? '' }}
                                </span>
                                <span class="bg-[#9E203F] text-white font-bold px-2 py-1 rounded text-xs">
                                    €{{ number_format($product->price, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end ml-4 min-w-[120px]">
                        <span class="text-xs text-gray-400">User</span>
                        <span class="font-semibold text-[#9E203F] text-sm truncate">
                            {{ $product->user->name ?? 'Desconocido' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="p-4 text-gray-500 text-base text-center">No se encontraron productos.</div>
            @endforelse
        </div>
    @endif
</div>
