@section('title', "$address->address - Detalles de Dirección")

<div class="max-w-xl mx-auto py-10 px-4 sm:px-8">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        {{-- Imagen principal --}}
        <div class="w-full h-60 bg-gray-100 flex items-center justify-center relative cursor-pointer group"
            x-data="{
                images: @js($address->images?->pluck('path') ?? ($address->image ? [$address->image] : [])),
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
                get imageUrl() { return this.hasImages ? '{{ asset('storage') }}/' + this.images[this.current] : '' }
            }" x-effect="direction = current > prev ? 'right' : 'left'; prev = current">
            <div class="w-full h-full flex items-center justify-center" @click="if(hasImages) showModal = true"
                title="Ampliar imágenes" @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">
                <div class="w-full h-full flex items-center justify-center">
                    <div x-show="hasImages" class="relative w-full h-60 overflow-hidden">
                        <template x-for="(img, idx) in images" :key="img">
                            <img x-show="current === idx" :src="'{{ asset('storage') }}/' + img"
                                alt="Imagen de la dirección"
                                class="w-full h-60 object-cover absolute inset-0 transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)] rounded-none"
                                :class="{
                                    'opacity-0 -translate-x-6 scale-95': current !== idx && direction === 'right',
                                    'opacity-0 translate-x-6 scale-95': current !== idx && direction === 'left',
                                    'opacity-100 translate-x-0 scale-100': current === idx
                                }">
                        </template>
                        <button type="button"
                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-2 flex items-center justify-center transition opacity-80 hover:opacity-100"
                            x-show="current > 0" @click.stop="current--; direction = 'left'" aria-label="Anterior">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-2 flex items-center justify-center transition opacity-80 hover:opacity-100"
                            x-show="current < images.length - 1" @click.stop="current++; direction = 'right'"
                            aria-label="Siguiente">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
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
                        class="flex items-center justify-center w-full h-60 bg-gray-100 text-gray-400 text-lg font-semibold">
                        Sin imagen
                    </div>
                </div>
            </div>
            {{-- Modal de galería ampliada --}}
            <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80" x-cloak
                @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">
                <div class="relative w-full max-w-3xl mx-auto">
                    <button @click="showModal = false"
                        class="absolute top-4 right-4 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="bg-white rounded-lg p-4 flex flex-col items-center" @click.away="showModal = false">
                        <div class="relative w-full flex items-center justify-center" style="min-height: 400px;">
                            <template x-for="(img, idx) in images" :key="'modal-' + img">
                                <img x-show="current === idx" :src="'{{ asset('storage') }}/' + img"
                                    alt="Imagen ampliada"
                                    class="max-h-[70vh] max-w-full object-contain mx-auto transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
                                    :class="{
                                        'opacity-0 -translate-x-6 scale-95': current !== idx &&
                                            direction === 'right',
                                        'opacity-0 translate-x-6 scale-95': current !== idx && direction === 'left',
                                        'opacity-100 translate-x-0 scale-100': current === idx
                                    }">
                            </template>
                            <button type="button"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-2 flex items-center justify-center transition opacity-80 hover:opacity-100"
                                x-show="current > 0" @click="current--; direction = 'left'" aria-label="Anterior">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-2 flex items-center justify-center transition opacity-80 hover:opacity-100"
                                x-show="current < images.length - 1" @click="current++; direction = 'right'"
                                aria-label="Siguiente">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        {{-- Miniaturas --}}
                        <div class="flex gap-2 mt-4">
                            <template x-for="(img, idx) in images" :key="'thumb-' + img">
                                <img :src="'{{ asset('storage') }}/' + img" @click="current = idx"
                                    :class="current === idx ? 'ring-2 ring-blue-500' : 'opacity-70 hover:opacity-100'"
                                    class="w-16 h-16 object-cover rounded cursor-pointer transition-all duration-200 border border-gray-200">
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Contenido --}}
        <div class="p-8">
            <div class="flex items-center justify-between mb-2">
                <h1 class="text-2xl font-bold text-gray-900">{{ $address->address }}</h1>
            </div>
            <div class="text-gray-500 text-sm mb-4">
                @if ($address->user)
                    <a href="{{ route('public.profile', [$address->user->id]) }}" class="flex items-center gap-2">
                        @if ($address->user->profile_photo_url)
                            <img src="{{ $address->user->profile_photo_url }}" alt="Foto de perfil"
                                class="w-7 h-7 rounded-full object-cover border border-gray-300">
                        @else
                            <span
                                class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user"></i>
                            </span>
                        @endif
                        <span class="font-medium">{{ $address->user->name }}</span>
                    </a>
                @else
                    <span class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                        <i class="fas fa-user"></i>
                    </span>
                    <span class="font-medium">Desconocido</span>
                @endif
            </div>
            <ul class="mb-6 text-base text-gray-700 space-y-2">
                <li>
                    <span class="font-semibold text-gray-800">Nombre:</span>
                    <span class="ml-2">{{ $address->name ?? 'N/A' }}</span>
                </li>
                <li>
                    <span class="font-semibold text-gray-800">Tipo:</span>
                    <span class="ml-2">{{ $address->addressType->name ?? 'N/A' }}</span>
                </li>
                <li>
                    <span class="font-semibold text-gray-800">Creado:</span>
                    <span class="ml-2">{{ $address->created_at->format('d/m/Y H:i') }}</span>
                </li>
            </ul>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('address.edit', $address) }}"
                    class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                    <i class="fas fa-edit"></i>
                    <span>Editar</span>
                </a>
                <a href="{{ route('address.index') }}"
                    class="flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>
    </div>
</div>
