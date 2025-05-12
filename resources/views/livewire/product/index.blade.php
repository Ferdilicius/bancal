@section('title', 'Todos los Productos')

<div class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Productos</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <a href="{{ route('product.show', $product->id) }}"
                class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="mb-4">
                    @if ($product->image)
                        <img src="{{$product->image}}" alt="Imagen del producto"
                            class="w-full h-32 object-cover rounded">
                    @else
                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center rounded">
                            <span class="text-gray-500">Sin imagen</span>
                        </div>
                    @endif
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                <p class="text-gray-700 font-semibold mb-2">Cantidad: {{ $product->quantity }}</p>
                <p class="text-gray-700 font-semibold mb-2">Precio: {{ $product->price }}</p>
                <p>
                    <span
                        class="{{ $product->status ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                        {{ $product->status ? 'Activo' : 'Inactivo' }}
                    </span>
                </p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        <div class="bg-white p-4 rounded-lg shadow-md">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</div>
