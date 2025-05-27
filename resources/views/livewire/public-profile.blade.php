@section('title', 'Perfil Público de ' . $user->name)

<div class="max-w-6xl mx-auto mt-14 px-2 sm:px-6 mb-10">
    <div class="bg-white shadow-xl rounded-3xl p-6 sm:p-10">
        <h1 class="text-3xl font-extrabold mb-10 text-gray-900">Perfil Público de {{ $user->name }}</h1>

        @if ($products->isNotEmpty())
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($products as $product)
                    <a href="{{ route('product.show', $product->id) }}"
                        class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-xl transition-shadow duration-200 flex flex-col justify-between p-6 group">
                        <div class="mb-5">
                            <x-product-image :product="$product" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">
                            {{ $product->name }}
                        </h3>
                        <span class="block text-gray-700 text-sm">Precio: <span class="font-semibold">${{ number_format($product->price, 2) }}</span></span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center mt-20">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-6"></i>
                <p class="text-gray-500 text-center text-xl font-semibold mb-2">Este usuario no tiene productos publicados.</p>
            </div>
        @endif
    </div>
</div>
