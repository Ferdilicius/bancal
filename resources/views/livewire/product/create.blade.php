@section('title', 'Crear Producto')

<div class="max-w-4xl mx-auto p-8 my-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Crear Nuevo Producto</h1>
    <form wire:submit.prevent="storeProduct" class="space-y-8" enctype="multipart/form-data">

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Nombre del Producto</label>
            <input type="text" id="name" wire:model="name"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('name')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descripción --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700">Descripción</label>
            <textarea id="description" wire:model="description"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            @error('description')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cantidad --}}
        <div>
            <label for="quantity" class="block text-sm font-semibold text-gray-700">Cantidad</label>
            <input type="number" id="quantity" wire:model="quantity" min="0"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('quantity')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Precio --}}
        <div>
            <label for="price" class="block text-sm font-semibold text-gray-700">Precio</label>
            <input type="number" id="price" wire:model="price" step="0.01"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('price')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Imágenes múltiples --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Imágenes</label>
            <input type="file" wire:model="images" multiple
                class="mt-2 block w-full text-gray-700 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('images.*')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror

            {{-- Vista previa --}}
            <div class="mt-4 flex flex-wrap gap-4">
                @if ($images)
                    @foreach ($images as $key => $image)
                        <div class="w-24 h-24 overflow-hidden rounded-md border border-gray-300">
                            <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Estado con radios --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="status" value="0"
                        class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-gray-700">Inactivo</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="status" value="1"
                        class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-gray-700">Activo</span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Categoría --}}
        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700">Categoría</label>
            <select id="category_id" wire:model="category_id"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" selected>Selecciona una categoría</option>
                @foreach ($this->categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botón --}}
        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Guardar Producto
        </button>
    </form>
</div>
