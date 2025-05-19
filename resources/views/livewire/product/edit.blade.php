@section('title', 'Editar Producto ' . $product->name)

<div class="max-w-4xl mx-auto p-8 my-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Editar Producto</h1>
    <form wire:submit.prevent="updateProduct" class="space-y-8">

        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Nombre del Producto</label>
            <input type="text" wire:model="name"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('name')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Descripción --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Descripción</label>
            <textarea wire:model="description"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            @error('description')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cantidad --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Cantidad</label>
            <input type="number" wire:model="quantity" min="0"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('quantity')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Precio --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Precio</label>
            <input type="number" wire:model="price" step="0.01"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('price')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Imágenes múltiples --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Nuevas Imágenes</label>
            <input type="file" wire:model="images" multiple
                class="mt-2 block w-full text-gray-700 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('images.*')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror

            {{-- Vista previa de nuevas imágenes --}}
            <div class="mt-4 flex flex-wrap gap-4">
                @foreach ($images as $image)
                    <div class="w-24 h-24 overflow-hidden rounded-md border border-gray-300">
                        <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                    </div>
                @endforeach
            </div>

            {{-- Imágenes existentes --}}
            <div class="mt-4">
                <label class="block text-sm font-semibold text-gray-700">Imágenes Actuales</label>
                <div class="mt-2 flex flex-wrap gap-4">
                    @foreach ($existingImages as $img)
                        <div class="w-24 h-24 overflow-hidden rounded-md border border-gray-300">
                            <img src="{{ Storage::url($img) }}" class="object-cover w-full h-full">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Estado como radio --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Estado</label>
            <div class="flex items-center gap-6 mt-2">
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="status" value="0" class="text-indigo-600">
                    <span>Inactivo</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="status" value="1" class="text-indigo-600">
                    <span>Activo</span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Categoría --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Categoría</label>
            <select wire:model="category_id"
                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Selecciona una categoría</option>
                @foreach ($categories as $category)
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
            Actualizar Producto
        </button>
    </form>
</div>
