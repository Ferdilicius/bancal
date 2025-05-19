@section('title', 'Carrito de la compra')

<div class="shopping-cart">
    <h2>Shopping Cart</h2>
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Product</th>
                <th class="border border-gray-300 px-4 py-2">Quantity</th>
                <th class="border border-gray-300 px-4 py-2">Price</th>
                <th class="border border-gray-300 px-4 py-2">Total</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        {{-- <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['name'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="number" wire:model="cartItems.{{ $loop->index }}.quantity" min="1"
                            class="w-16 text-center border border-gray-300">
                    </td>
                    <td class="border border-gray-300 px-4 py-2">${{ number_format($item['price'], 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button wire:click="removeItem({{ $loop->index }})" class="text-red-500">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody> --}}
    </table>

    {{-- <div class="mt-4 flex justify-between items-center">
        <h3 class="text-lg font-bold">Total: ${{ number_format($total, 2) }}</h3>
        <button wire:click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded">Checkout</button>
    </div> --}}
</div>
