@section('title', "$product->name - Detalles producto")

<div class="max-w-6xl mx-auto py-6 px-6 sm:px-12 text-lg">
    <a href="{{ route('product.index') }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver al inicio
    </a>

    <div class="bg-white shadow-lg rounded-xl flex flex-col md:flex-row overflow-hidden">
        {{-- Imagen principal --}}
        <div class="md:w-1/2 w-full bg-gray-100 flex items-center justify-center relative cursor-pointer group"
            style="height: auto; min-height: 20rem;" x-data="{
                images: @js($product->images->map(fn($img) => ['id' => $img->id])->toArray()),
                current: 0,
                prev: 0,
                direction: 'right',
                showModal: false,
                startX: null,
                handleTouchStart(e) {
                    this.startX = e.touches[0].clientX;
                },
                handleTouchEnd(e) {
                    if (this.startX === null) return;
                    let endX = e.changedTouches[0].clientX;
                    let diff = endX - this.startX;
                    if (Math.abs(diff) > 40) {
                        if (diff < 0 && this.current < this.images.length - 1) {
                            this.current++;
                            this.direction = 'right';
                        } else if (diff > 0 && this.current > 0) {
                            this.current--;
                            this.direction = 'left';
                        }
                    }
                    this.startX = null;
                },
                get hasImages() { return this.images.length > 0 },
            }"
            x-effect="direction = current > prev ? 'right' : 'left'; prev = current">

            <div class="w-full h-full flex items-center justify-center" @click="if(hasImages) showModal = true"
                title="Ampliar imágenes" @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">

                <div class="w-full h-full flex items-center justify-center">
                    <div x-show="hasImages" class="relative w-full h-full min-h-[20rem] overflow-hidden">
                        <template x-for="(img, idx) in images" :key="img.id">
                            <img x-show="current === idx" :src="'{{ url('/productos') }}/{{ $product->id }}/' + img.id"
                                class="w-full h-full object-cover absolute inset-0 transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
                                :class="{
                                    'opacity-0 -translate-x-6 scale-95': current !== idx && direction === 'right',
                                    'opacity-0 translate-x-6 scale-95': current !== idx && direction === 'left',
                                    'opacity-100 translate-x-0 scale-100': current === idx
                                }">
                        </template>
                        <button type="button"
                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-3 flex items-center justify-center transition opacity-80 hover:opacity-100"
                            x-show="current > 0" @click.stop="current--; direction = 'left'" aria-label="Anterior">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-3 flex items-center justify-center transition opacity-80 hover:opacity-100"
                            x-show="current < images.length - 1" @click.stop="current++; direction = 'right'"
                            aria-label="Siguiente">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        {{-- Puntos indicadores --}}
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="(img, idx) in images" :key="'dot-' + idx">
                                <button type="button" class="w-3 h-3 rounded-full transition-all"
                                    :class="current === idx ? 'bg-white shadow border-2 border-gray-400' :
                                        'bg-gray-400/60 opacity-70'"
                                    @click.stop="current = idx" aria-label="Ir a imagen"></button>
                            </template>
                        </div>
                    </div>
                    <div x-show="!hasImages"
                        class="flex items-center justify-center w-full h-full min-h-[20rem] bg-gray-100 text-gray-400 text-lg font-semibold">
                        Sin imagen
                    </div>
                </div>
            </div>

            {{-- Modal de galería ampliada --}}
            <div x-show="showModal" style="background-color: rgba(0,0,0,0.8);"
                class="fixed inset-0 z-50 flex items-center justify-center"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak
                @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">

                <div class="relative w-full max-w-3xl mx-auto ">
                    <button @click="showModal = false"
                        class="absolute top-4 right-4 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="bg-white rounded-lg p-4 flex flex-col items-center" @click.away="showModal = false">
                        <div class="relative w-full flex items-center justify-center" style="min-height: 400px;">
                            <template x-for="(img, idx) in images" :key="'modal-' + img.id">
                                <img x-show="current === idx"
                                    :src="'{{ url('/productos') }}/{{ $product->id }}/' + img.id" alt="Imagen ampliada"
                                    class="max-h-[70vh] max-w-full object-contain mx-auto transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
                                    :class="{
                                        'opacity-0 -translate-x-6 scale-95': current !== idx &&
                                            direction === 'right',
                                        'opacity-0 translate-x-6 scale-95': current !== idx && direction === 'left',
                                        'opacity-100 translate-x-0 scale-100': current === idx
                                    }">
                            </template>
                            <button type="button"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-3 flex items-center justify-center transition opacity-80 hover:opacity-100"
                                x-show="current > 0" @click="current--; direction = 'left'" aria-label="Anterior">
                                <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-3 flex items-center justify-center transition opacity-80 hover:opacity-100"
                                x-show="current < images.length - 1" @click="current++; direction = 'right'"
                                aria-label="Siguiente">
                                <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        {{-- Miniaturas --}}
                        <div class="flex gap-2 mt-4">
                            <template x-for="(img, idx) in images" :key="'thumb-' + img.id">
                                <img :src="'{{ url('/productos') }}/{{ $product->id }}/' + img.id"
                                    @click="current = idx"
                                    :class="current === idx ? 'ring-2 ring-blue-500' : 'opacity-70 hover:opacity-100'"
                                    class="w-16 h-16 object-cover rounded cursor-pointer transition-all duration-200 border border-gray-200">
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contenido --}}
        <div class="md:w-1/2 w-full p-8 flex flex-col justify-center">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <span
                    class="text-xl font-extrabold bg-green-500 text-white px-5 py-2 rounded-full">{{ number_format($product->price, 2) }}€</span>
            </div>

            <a href="{{ $product->user ? route('public.profile', $product->user) : '#' }}" title="Ver perfil público"
                class="block">
                <div class="flex items-center gap-3 mb-6 bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition">
                    @if ($product->user && $product->user->profile_photo_url)
                        <img src="{{ $product->user->profile_photo_url }}" alt="Foto de perfil"
                            class="w-10 h-10 rounded-full object-cover border border-gray-300">
                    @elseif ($product->user)
                        <span
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <i class="fas fa-user"></i>
                        </span>
                    @else
                        <span
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <i class="fas fa-user"></i>
                        </span>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-800">
                            {{ $product->user->name ?? 'Desconocido' }}
                        </div>
                        <div class="text-xs text-gray-500">Productor local</div>
                    </div>
                </div>
            </a>
            @if ($product->address && $product->address->status === 'activo')
                <a href="{{ route('address.show', $product->address->id) }}"
                    class="mb-6 flex items-center gap-2 hover:bg-blue-50 rounded py-1 transition">
                    <i class="fas fa-map-marker-alt text-blue-500 px-2"></i>
                    <span class="font-semibold text-gray-800">Bancal de procedencia:</span>
                    <span class="text-blue-600 font-semibold hover:underline">
                        {{ $product->address->name }}
                    </span>
                </a>
            @endif
            <div class="px-2">
                <div class="mb-6">
                    <div class="font-semibold text-gray-800 mb-1">Descripción:</div>
                    <div class="text-gray-600">{{ $product->description ?? 'N/A' }}</div>
                </div>
                <div class="mb-6">
                    <div class="font-semibold text-gray-800 mb-1">Categoría:</div>
                    <div class="text-gray-600">{{ $product->category->name ?? 'Sin categoría' }}</div>
                </div>
                <div class="mb-6">
                    <div class="font-semibold text-gray-800">Cantidad disponible:</div>
                    <div class=" text-gray-600">{{ $product->formatted_quantity ?? 'N/A' }}</div>
                </div>

                @auth
                    @if (auth()->id() === optional($product->user)->id)
                        <div class="mb-6">
                            <div class="flex items-center gap-2 bg-yellow-100 text-yellow-800 px-4 py-3 rounded mb-2">
                                <i class="fas fa-user-check"></i>
                                <span>Este producto es tuyo.</span>
                            </div>
                            <a href="{{ route('product.edit', $product->id) }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                                <i class="fas fa-edit"></i>
                                <span>Editar producto</span>
                            </a>
                        </div>
                    @else
                        <!-- Botones de compra y añadir al carrito -->
                        <div class="flex flex-col gap-4 sm:flex-row items-stretch">
                            <div class="relative flex items-center w-full sm:w-36 flex-shrink-0">
                                @if ($product->allow_fractional)
                                    <span class="relative group text-indigo-500 cursor-pointer pr-2 flex items-center"
                                        tabindex="0" aria-label="Información sobre el límite de compra">
                                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                                        <div class="absolute right-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                            role="tooltip">
                                            @if ($product->min_per_person && !$product->max_per_person)
                                                <div>
                                                    Mínimo
                                                    <strong>{{ $product->getFormattedMinPerPersonAttribute() }}</strong>
                                                    por persona.
                                                </div>
                                            @elseif ($product->max_per_person && !$product->min_per_person)
                                                <div>
                                                    Máximo
                                                    <strong>{{ $product->getFormattedMaxPerPersonAttribute() }}</strong>
                                                    por persona.
                                                </div>
                                            @elseif ($product->max_per_person && $product->min_per_person)
                                                <div>
                                                    Mínimo <strong>{{ $product->min_per_person }}</strong> y máximo
                                                    <strong>{{ $product->getFormattedMaxPerPersonAttribute() }}</strong>
                                                    por persona.
                                                </div>
                                            @else
                                                <div>
                                                    Este producto se puede comprar en fracciones.
                                                </div>
                                            @endif
                                        </div>
                                    </span>
                                @endif

                                <input type="number" wire:model.lazy="quantity" inputmode="numeric"
                                    min="{{ $product->allow_fractional ? $product->min_per_person ?? 0.01 : $product->quantity }}"
                                    max="{{ $product->allow_fractional ? $product->max_per_person ?? $product->quantity : $product->quantity }}"
                                    step="1" pattern="\d*" {{ $product->allow_fractional ? '' : 'readonly' }}
                                    class="border border-gray-300 rounded px-3 py-2 w-full bg-white disabled:bg-gray-100 disabled:cursor-not-allowed"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');" />
                            </div>

                            <div class="flex flex-col gap-2 w-full sm:flex-row sm:w-auto">
                                <button wire:click="buyNow"
                                    class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition w-full sm:w-auto">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="sm:inline">Comprar Ahora</span>
                                </button>
                                <button wire:click="addToCart"
                                    class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition w-full sm:w-auto">
                                    <i class="fas fa-cart-plus"></i>
                                    <span class="sm:inline">Añadir al Carrito</span>
                                </button>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="flex gap-4">
                        <div class="relative flex items-center w-full sm:w-36 flex-shrink-0">
                            @if ($product->allow_fractional)
                                <span class="relative group text-indigo-500 cursor-pointer pr-2 flex items-center"
                                    tabindex="0" aria-label="Información sobre el límite de compra">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    <div class="absolute right-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                                        role="tooltip">
                                        @if ($product->min_per_person && !$product->max_per_person)
                                            <div>
                                                Mínimo <strong>{{ $product->getFormattedMinPerPersonAttribute() }}</strong>
                                                por persona.
                                            </div>
                                        @elseif ($product->max_per_person && !$product->min_per_person)
                                            <div>
                                                Máximo <strong>{{ $product->getFormattedMaxPerPersonAttribute() }}</strong>
                                                por persona.
                                            </div>
                                        @elseif ($product->max_per_person && $product->min_per_person)
                                            <div>
                                                Mínimo <strong>{{ $product->min_per_person }}</strong> y máximo
                                                <strong>{{ $product->getFormattedMaxPerPersonAttribute() }}</strong>
                                                por persona.
                                            </div>
                                        @else
                                            <div>
                                                Este producto se puede comprar en fracciones.
                                            </div>
                                        @endif
                                    </div>
                                </span>
                            @endif

                            <input type="number" wire:model.lazy="quantity" inputmode="numeric"
                                min="{{ $product->allow_fractional ? $product->min_per_person ?? 0.01 : $product->quantity }}"
                                max="{{ $product->allow_fractional ? $product->max_per_person ?? $product->quantity : $product->quantity }}"
                                step="1" pattern="\d*" {{ $product->allow_fractional ? '' : 'readonly' }}
                                class="border border-gray-300 rounded px-3 py-2 w-full bg-white disabled:bg-gray-100 disabled:cursor-not-allowed"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');" />
                        </div>

                        <button wire:click="buyNow"
                            class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Comprar Ahora</span>
                        </button>
                        <button wire:click="addToCart"
                            class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                            <i class="fas fa-cart-plus"></i>
                            <span>Añadir al Carrito</span>
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @if ($relatedProducts && $relatedProducts->count())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">También te puede interesar</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $related)
                    <a href="{{ route('product.show', $related->id) }}"
                        class="bg-white border border-gray-200 rounded-lg shadow-md p-3 hover:shadow-lg transition-shadow duration-200 flex flex-col">
                        @php
                            $firstImage = $related->images->first();
                        @endphp
                        @if ($firstImage)
                            <img src="{{ route('product.image', ['productId' => $related->id, 'imageId' => $firstImage->id]) }}"
                                alt="Imagen producto"
                                class="w-full h-28 object-cover rounded-t-lg mb-2 transition-transform duration-200 hover:scale-105">
                        @else
                            <div
                                class="w-full h-28 bg-gray-300 flex items-center justify-center rounded-t-lg mb-2 text-gray-500">
                                Sin imagen
                            </div>
                        @endif
                        <h3 class="text-base font-bold text-gray-800 mb-1 truncate">{{ $related->name }}</h3>
                        <p class="text-gray-700 font-semibold mb-1 text-sm">Cantidad:
                            {{ $related->formatted_quantity }}</p>
                        <p class="text-gray-700 font-semibold text-sm">Precio: {{ $related->price }}€</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
