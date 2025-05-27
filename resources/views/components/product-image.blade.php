@if ($product->images->isNotEmpty())
    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="Imagen del producto"
        class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-200">
@else
    <div
        class="flex items-center justify-center w-full h-48 bg-gray-100 rounded-lg border border-gray-200 shadow-sm text-gray-500 text-sm font-semibold">
        Sin imagen
    </div>
@endif
