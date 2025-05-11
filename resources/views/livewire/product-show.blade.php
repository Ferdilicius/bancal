@section('title', "$product->name - Product Details")
    
<div class="container mx-auto p-8">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Product Details</h1>
        <div class="text-lg text-gray-700 space-y-4">
            <p><strong class="font-semibold">Name:</strong> {{ $product->name }}</p>
            <p><strong class="font-semibold">Description:</strong> {{ $product->description ?? 'N/A' }}</p>
            <p><strong class="font-semibold">Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong class="font-semibold">Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong class="font-semibold">Status:</strong>
                <span class="{{ $product->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->status ? 'Active' : 'Inactive' }}
                </span>
            </p>
            <p><strong class="font-semibold">Uploaded By:</strong> {{ $product->user->name ?? 'Unknown' }}</p>
        </div>
        @if ($product->image)
            <div class="mt-6">
                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                    class="w-64 h-64 object-cover rounded-lg shadow-md">
            </div>
        @endif
        <div class="mt-6 flex space-x-4">
            <a href="#"
                class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Ver Perfil del Vendedor
            </a>
            <a href="#"
                class="bg-green-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                Comprar
            </a>
        </div>
    </div>
</div>
