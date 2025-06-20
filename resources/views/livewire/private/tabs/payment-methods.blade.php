<div class="space-y-4">
    <h2 class="text-xl font-semibold text-gray-800">Tus métodos de pago</h2>

    @if (session()->has('message'))
        <div class="text-green-600">{{ session('message') }}</div>
    @endif

    <button wire:click="$toggle('showAddForm')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Añadir método de pago
    </button>

    @if ($showAddForm)
        <form wire:submit.prevent="addMethod" class="space-y-3 bg-gray-50 p-4 rounded mt-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select wire:model="newMethod.type" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="">Selecciona un tipo</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
                @error('newMethod.type')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <input type="text" wire:model="newMethod.provider" class="mt-1 block w-full border-gray-300 rounded"
                    placeholder="Ej: Visa, BBVA, etc." />
                @error('newMethod.provider')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre de cuenta</label>
                <input type="text" wire:model="newMethod.account_name" class="mt-1 block w-full border-gray-300 rounded"
                    placeholder="Ej: Juan Pérez" />
                @error('newMethod.account_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                <input type="text" wire:model="newMethod.account_number" class="mt-1 block w-full border-gray-300 rounded"
                    placeholder="Ej: 1234567890 o IBAN" />
                @error('newMethod.account_number')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de expiración</label>
                <input type="date" wire:model="newMethod.expiration_date"
                    class="mt-1 block w-full border-gray-300 rounded" />
                @error('newMethod.expiration_date')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="newMethod.is_default" class="mr-2" />
                <label class="text-sm text-gray-700">Establecer como método predeterminado</label>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Guardar</button>
                <button type="button" wire:click="$set('showAddForm', false)"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
            </div>
        </form>
    @endif

    <div class="space-y-2">
        @foreach ($paymentMethods as $method)
            <div class="p-4 bg-gray-100 rounded flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $method->type }}</p>
                    <p class="text-sm text-gray-500">{{ $method->details }}</p>
                </div>
                <div class="flex gap-2">
                    <button wire:click="deleteMethod({{ $method->id }})"
                        class="text-red-600 hover:underline">Eliminar</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
