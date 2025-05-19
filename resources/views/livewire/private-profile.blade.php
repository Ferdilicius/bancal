@section('title', 'Mi perfil')

<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Mi perfil</h1>

        <div class="mb-4">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Productos</h2>
            <div class="mb-4 flex justify-end">
                <a href="{{ route('product.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Agregar Producto
                </a>
            </div>
            @if ($products->isNotEmpty())
                <div class="p-6 bg-gray-100 rounded-lg">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Productos</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div
                                class="relative bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <a href="{{ route('product.show', $product->id) }}" class="block"
                                    style="text-decoration: none;">
                                    <div class="mb-4">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="Imagen del producto" class="w-full h-32 object-cover rounded">
                                        @else
                                            <div
                                                class="w-full h-32 bg-gray-200 flex items-center justify-center rounded">
                                                <span class="text-gray-500">Sin imagen</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                                    <p class="text-gray-600 mb-2 truncate">{{ $product->description }}</p>
                                    <p class="text-gray-700 font-semibold mb-2">Cantidad: {{ $product->quantity }}</p>
                                    <p class="text-gray-700 font-semibold mb-2">Precio:
                                        ${{ number_format($product->price, 2) }}</p>
                                    <p>
                                        <span
                                            class="{{ $product->status ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                            {{ $product->status ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </p>
                                </a>
                                <div class="mt-4 flex justify-between">
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors duration-200"
                                        onclick="event.stopPropagation();">
                                        Editar
                                    </a>
                                    <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)" onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors duration-200">
                                            Borrar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-500">No tienes productos</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmDelete(event) {
            if (!confirm('¿Estás seguro de que deseas borrar este producto?')) {
                event.preventDefault();
                return false;
            }
            if (!confirm('Esta acción no se puede deshacer. ¿Estás completamente seguro?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
@endpush
