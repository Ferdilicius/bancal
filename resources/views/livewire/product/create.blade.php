<div class="max-w-4xl mx-auto p-8 my-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Crear Nuevo Producto</h1>
    <form wire:submit.prevent="storeProduct" class="space-y-8">
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Nombre del Producto</label>
            <input type="text" id="name" wire:model="name" required
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('name')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700">Descripción</label>
            <textarea id="description" wire:model="description"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            @error('description')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="quantity" class="block text-sm font-semibold text-gray-700">Cantidad</label>
            <input type="number" id="quantity" wire:model="quantity" min="0" required
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('quantity')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="price" class="block text-sm font-semibold text-gray-700">Precio</label>
            <input type="number" id="price" wire:model="price" step="0.01" required
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('price')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-semibold text-gray-700">Imagen</label>
            <input type="file" id="image" wire:model="image"
                class="mt-2 block w-full text-gray-700 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('image')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700">Estado</label>
            <select id="status" wire:model="status"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" selected>Selecciona el estado</option>
                <option value="0">Inactivo</option>
                <option value="1">Activo</option>
            </select>
            @error('status')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Guardar Producto
        </button>
    </form>
</div>
