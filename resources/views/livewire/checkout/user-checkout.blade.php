@section('title', 'Checkout')

<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Finalizar Compra</h1>

    @error('general')
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">{{ $message }}</div>
    @enderror

    <div class="mb-6">
        <label class="block mb-1 font-semibold">Dirección:</label>

        @if (auth()->user()->addresses->isEmpty())
            <div class="bg-yellow-100 text-yellow-700 p-2 rounded mb-2">
                No tienes direcciones guardadas.
            </div>
            <a href="{{ route('address.create') }}" class="text-blue-600 underline">Agregar nueva dirección</a>
        @else
            <select wire:model="address_id" class="w-full p-2 border rounded">
                @foreach (auth()->user()->addresses as $address)
                    <option value="{{ $address->id }}">{{ $address->street }}, {{ $address->city }}</option>
                @endforeach
            </select>
        @endif

        @error('address_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>


    <div class="mb-6">
        <label class="block mb-1 font-semibold">Método de pago:</label>

        @if (auth()->user()->paymentMethods->isEmpty())
            <div class="bg-yellow-100 text-yellow-700 p-2 rounded mb-2">
                No tienes métodos de pago guardados.
            </div>
            <a href="{{ route('payment_method.create') }}" class="text-blue-600 underline">Agregar método de pago</a>
        @else
            <select wire:model="payment_method_id" class="w-full p-2 border rounded">
                @foreach (auth()->user()->paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->name }} ({{ $method->type }})</option>
                @endforeach
            </select>
        @endif

        @error('payment_method_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex justify-between items-center mt-6">
        <span class="text-xl font-bold">Total: {{ number_format($total, 2) }}€</span>
        <button wire:click="placeOrder" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Confirmar Pedido
        </button>
    </div>
</div>
