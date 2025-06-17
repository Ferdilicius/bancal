<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tu carrito</h2>

    @if (empty($cart))
        <div class="text-gray-500">Tu carrito está vacío.</div>
    @else
        <div class="space-y-4">
            @foreach ($cart as $item)
                <div class="flex items-center justify-between bg-white p-4 rounded shadow">
                    <div class="flex items-center gap-4">
                        <div>
                            <div class="text-lg font-semibold text-[#9E203F]">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-600">
                                Cantidad: {{ $item['quantity'] }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-gray-600 text-sm">Precio unitario</div>
                        <div class="font-bold text-[#9E203F]">€{{ number_format($item['price'], 2, ',', '.') }}</div>
                        <div class="text-sm text-gray-500 mt-1">
                            Subtotal: €{{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-right mt-6 border-t pt-4">
                <div class="text-lg font-bold text-[#9E203F]">
                    Total: €
                    {{
                        number_format(
                            collect($cart)->reduce(fn ($total, $item) => $total + ($item['price'] * $item['quantity']), 0),
                            2,
                            ',',
                            '.'
                        )
                    }}
                </div>
            </div>
        </div>
    @endif
</div>
