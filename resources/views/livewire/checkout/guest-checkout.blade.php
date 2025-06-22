@section('title', 'Checkout Invitado')

<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Compra como invitado</h1>

    @error('general')
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">{{ $message }}</div>
    @enderror

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h2 class="font-semibold text-lg mb-2">Datos personales</h2>
            <input type="text" wire:model="name" placeholder="Nombre" class="input mb-2 w-full">
            <input type="email" wire:model="email" placeholder="Correo electrónico" class="input mb-2 w-full">
            <input type="text" wire:model="phone" placeholder="Teléfono (opcional)" class="input mb-2 w-full">
        </div>

        <div>
            <h2 class="font-semibold text-lg mb-2">Dirección</h2>
            <input type="text" wire:model="street" placeholder="Calle" class="input mb-2 w-full">
            <input type="text" wire:model="city" placeholder="Ciudad" class="input mb-2 w-full">
            <input type="text" wire:model="zip" placeholder="Código Postal" class="input mb-2 w-full">
            <input type="text" wire:model="country" placeholder="País" class="input mb-2 w-full">
        </div>
    </div>

    <div class="mt-6">
        <h2 class="font-semibold text-lg mb-2">Método de Pago</h2>
        <select wire:model="payment_type" class="input w-full mb-2">
            <option value="">-- Selecciona método --</option>
            <option value="card">Tarjeta</option>
            <option value="paypal">PayPal</option>
            <option value="bizum">Bizum</option>
            <option value="other">Otro</option>
        </select>
        <input type="text" wire:model="payment_details" placeholder="Detalles (opcional)" class="input w-full">
    </div>

    <div class="flex justify-between items-center mt-6">
        <span class="text-xl font-bold">Total: {{ number_format($total, 2) }}€</span>
        <button wire:click="placeOrder" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Confirmar Pedido
        </button>
    </div>
</div>
