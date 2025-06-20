@section('title', "$address->name - Detalles Bancal")

<div class="max-w-5xl mx-auto py-10 px-4 sm:px-8">
    <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div class="bg-white shadow-lg rounded-xl flex flex-col md:flex-row overflow-hidden">
        {{-- Imagen principal --}}
        <div class="md:w-1/2 w-full h-80 bg-gray-100 flex items-center justify-center relative cursor-pointer group"
            x-data="{
                images: @js($address->images->map(fn($img) => ['id' => $img->id])->toArray()),
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
            }" x-effect="direction = current > prev ? 'right' : 'left'; prev = current">

            <div class="w-full h-full flex items-center justify-center" @click="if(hasImages) showModal = true"
                title="Ampliar imágenes" @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)">

                <div class="w-full h-full flex items-center justify-center">
                    <div x-show="hasImages" class="relative w-full h-80 overflow-hidden">
                        <template x-for="(img, idx) in images" :key="img.id">
                            <img x-show="current === idx" :src="'{{ url('/bancales') }}/{{ $address->id }}/' + img.id"
                                class="w-full h-80 object-cover absolute inset-0 transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
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
                        class="flex items-center justify-center w-full h-80 bg-gray-100 text-gray-400 text-lg font-semibold">
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
                                    :src="'{{ url('/bancales') }}/{{ $address->id }}/' + img.id" alt="Imagen ampliada"
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
                            <template x-for="(img, idx) in images" :key="'thumb-' + img.id">
                                <img :src="'{{ url('/bancales') }}/{{ $address->id }}/' + img.id"
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
                <h1 class="text-3xl font-bold text-gray-900">{{ $address->name }}</h1>
                <span class="text-xl font-extrabold bg-green-500 text-white px-5 py-2 rounded-full">
                    {{ $address->addressType->name ?? 'N/A' }}
                </span>
            </div>
            <a href="{{ $address->user ? route('public.profile', $address->user) : '#' }}" title="Ver perfil público"
                class="block">
                <div class="flex items-center gap-3 mb-6 bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition">
                    @if ($address->user && $address->user->profile_photo_url)
                        <img src="{{ $address->user->profile_photo_url }}" alt="Foto de perfil"
                            class="w-10 h-10 rounded-full object-cover border border-gray-300">
                    @elseif ($address->user)
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
                            {{ $address->user->name ?? 'Desconocido' }}
                        </div>
                        <div class="text-xs text-gray-500">Propietario</div>
                    </div>
                </div>
            </a>
            @if (!empty($address->latitude) && !empty($address->longitude))
                <div class="flex gap-4">
                    <a href="https://maps.google.com/?q={{ $address->latitude }},{{ $address->longitude }}"
                        target="_blank"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Ver en el mapa</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
