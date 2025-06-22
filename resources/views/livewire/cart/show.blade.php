@section('title', 'Tu Carrito')

<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6">Carrito de Compras</h1>

    @if (count($cart) > 0)
        <table class="w-full mb-6 border rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Producto</th>
                    <th class="p-3 text-center">Cantidad</th>
                    <th class="p-3 text-right">Precio</th>
                    <th class="p-3 text-right">Total</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item['name'] }}</td>
                        <td class="p-3 text-center">
                            <button wire:click="decrease({{ $id }})" class="px-2">−</button>
                            {{ $item['quantity'] }}
                            <button wire:click="increase({{ $id }})" class="px-2">+</button>
                        </td>
                        <td class="p-3 text-right">{{ number_format($item['price'], 2) }}€</td>
                        <td class="p-3 text-right">{{ number_format($item['price'] * $item['quantity'], 2) }}€</td>
                        <td class="p-3 text-right">
                            <button wire:click="remove({{ $id }})"
                                class="text-red-600 hover:underline">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center mb-6">
            <span class="text-xl font-semibold">Total: {{ number_format($total, 2) }}€</span>
            <button wire:click="proceedToCheckout" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                Ir al Checkout
            </button>
        </div>
    @else
        <p class="text-gray-600">Tu carrito está vacío.</p>
    @endif
</div>
