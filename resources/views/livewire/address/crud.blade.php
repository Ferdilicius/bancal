@section('title', $addressId ? 'Editar Dirección' : 'Crear Dirección')

<div x-data="{
    submit() { $wire.save() },
        initMap() {
            let waitForLeaflet = () => {
                if (typeof L === 'undefined') {
                    setTimeout(waitForLeaflet, 100);
                    return;
                }
                let lat = $wire.latitude ?? 40.4168;
                let lng = $wire.longitude ?? -3.7038;
                let map = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                let marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    let pos = marker.getLatLng();
                    $wire.set('latitude', pos.lat);
                    $wire.set('longitude', pos.lng);
                });
                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    $wire.set('latitude', e.latlng.lat);
                    $wire.set('longitude', e.latlng.lng);
                });
                $watch('latitude', val => marker.setLatLng([val, $wire.longitude]));
                $watch('longitude', val => marker.setLatLng([$wire.latitude, val]));
            };
            waitForLeaflet();
        }
}" x-init="initMap()"
    class="max-w-3xl mx-auto p-10 my-14 bg-white shadow rounded border border-gray-200" role="form"
    aria-labelledby="address-form-title">
    <h1 id="address-form-title" class="text-3xl font-bold text-indigo-700 mb-10 text-center">
        {{ $addressId ? 'Editar Dirección' : 'Crear Dirección' }}
    </h1>
    <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">
        {{-- Nombre --}}
        <div class="mb-6">
            <label for="name" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Nombre
            </label>
            <input type="text" id="name" wire:model="name"
                class="mt-2 block w-64 border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true">
            @error('name')
                <span class="text-sm text-red-500 mt-2 block" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Dirección --}}
        <div class="mb-6">
            <label for="address" class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Dirección
            </label>
            <input type="text" id="address" wire:model="address"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true">
            @error('address')
                <span class="text-sm text-red-500 mt-2 block" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Tipo de dirección --}}
        <div class="mb-8">
            <label for="address_type_id"
                class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Tipo de dirección
            </label>
            <select id="address_type_id" wire:model="address_type_id"
                class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400"
                aria-required="true">
                <option value="" selected>Selecciona un tipo</option>
                @foreach ($addressTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('address_type_id')
                <span class="text-sm text-red-500 mt-2 block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        {{-- Mapa --}}
        <div class="mb-8">
            <label class="block text-base font-semibold text-gray-800 mb-2">Ubicación en el mapa</label>
            <div id="map" class="w-full h-72 rounded border border-gray-300"></div>
            <div class="flex gap-4 mt-2">
                <div>
                    <label class="text-xs text-gray-600">Latitud</label>
                    <input type="text" wire:model="latitude" class="w-32 border rounded px-2 py-1" readonly>
                </div>
                <div>
                    <label class="text-xs text-gray-600">Longitud</label>
                    <input type="text" wire:model="longitude" class="w-32 border rounded px-2 py-1" readonly>
                </div>
            </div>
        </div>

        {{-- Imágenes --}}
        <div class="mb-8" x-data="{ dragIndex: null }">
            <label for="images-upload" class="block text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                Imágenes de la dirección
            </label>
            <label for="images-upload" class="block w-full cursor-pointer mb-3">
                <input id="images-upload" type="file" wire:model="newImages" multiple accept="image/*"
                    class="hidden" />
                <span
                    class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-sm px-5 py-3 rounded border border-gray-300 hover:bg-indigo-100 transition">
                    <i class="fas fa-images mr-2" aria-hidden="true"></i> Seleccionar imágenes
                </span>
            </label>
            @error('images.*')
                <span class="text-sm text-red-500 mt-2 block" role="alert">{{ $message }}</span>
            @enderror

            @if ($images && count($images) > 0)
                <div class="mt-5 flex flex-wrap gap-6" aria-label="Vista previa de imágenes">
                    @foreach ($images as $key => $image)
                        @php
                            $imageId = null;
                            if (is_string($image) && isset($addressModel)) {
                                $imgModel = $addressModel->images->where('path', $image)->first();
                                $imageId = $imgModel ? $imgModel->id : null;
                            }
                        @endphp
                        <div class="relative group" draggable="true" @dragstart="dragIndex = {{ $key }}"
                            @dragover.prevent @drop="$wire.moveImage(dragIndex, {{ $key }}); dragIndex = null"
                            :class="{ 'ring-2 ring-indigo-400': dragIndex === {{ $key }} }"
                            aria-label="Imagen {{ $key + 1 }}">
                            @if ($imageId)
                                <img src="{{ route('address.image', ['addressId' => $addressModel->id, 'imageId' => $imageId]) }}"
                                    class="w-48 h-48 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Imagen de la dirección {{ $key + 1 }}">
                            @elseif (is_object($image) && method_exists($image, 'temporaryUrl'))
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-48 h-48 object-cover rounded-lg border-2 border-indigo-200 shadow group-hover:scale-105 transition-transform duration-200 cursor-move"
                                    alt="Imagen nueva {{ $key + 1 }}">
                            @endif
                            <button type="button" wire:click="removeImage({{ $key }})"
                                class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold shadow hover:bg-red-700 transition z-20"
                                title="Quitar imagen {{ $key + 1 }}"
                                aria-label="Quitar imagen {{ $key + 1 }}">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Estado --}}
        <div class="mb-8">
            <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-red-600">*</span>
                Estado
            </label>
            <div class="flex items-center gap-16" role="radiogroup" aria-label="Estado de la dirección">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="1"
                        class="form-radio w-6 h-6 text-green-600 focus:ring-green-500 transition-all duration-150"
                        aria-checked="{{ $status == 1 ? 'true' : 'false' }}" aria-label="Activo" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-green-700 transition">
                        Activo
                    </span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" wire:model="status" value="0"
                        class="form-radio w-6 h-6 text-red-600 focus:ring-red-500 transition-all duration-150"
                        aria-checked="{{ $status == 0 ? 'true' : 'false' }}" aria-label="Inactivo" />
                    <span
                        class="inline-flex items-center gap-1 text-base font-bold group-hover:text-red-700 transition">
                        Inactivo
                    </span>
                </label>
            </div>
            @error('status')
                <span class="text-sm text-red-500 mt-2 block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-6 mt-12">
            <button type="button" @click="submit"
                class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white py-4 px-8 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-600 font-bold text-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2"
                aria-label="{{ $addressId ? 'Actualizar Dirección' : 'Crear Dirección' }}">
                <i class="fas fa-save mr-2" aria-hidden="true"></i>
                {{ $addressId ? 'Actualizar Dirección' : 'Crear Dirección' }}
            </button>
            @if ($addressId)
                <div x-data="{ open: false }" class="flex-1">
                    <button type="button" @click="open = true"
                        class="w-full bg-red-600 text-white py-4 px-8 rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-200 flex justify-center items-center text-lg font-bold"
                        style="z-index:1;" aria-label="Borrar Dirección">
                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Borrar Dirección
                    </button>
                    <!-- Modal de confirmación -->
                    <div x-show="open" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                        role="dialog" aria-modal="true" aria-labelledby="modal-title">
                        <div class="bg-white rounded-xl shadow-lg p-10 max-w-sm w-full text-center"
                            @click.away="open = false" @keydown.escape.window="open = false">
                            <h2 id="modal-title" class="text-xl font-bold mb-6 text-gray-900">¿Seguro que quieres
                                borrar esta dirección?
                            </h2>
                            <p class="mb-8 text-gray-600">Esta acción es irreversible y no podrás recuperarla.</p>
                            <div class="flex gap-6 justify-center">
                                <button type="button" wire:click="delete"
                                    class="inline-flex items-center bg-red-700 text-white px-8 py-4 rounded-xl hover:bg-red-800 transition-colors duration-200 shadow-lg font-semibold text-base"
                                    aria-label="Confirmar borrado">
                                    <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Sí, borrar
                                </button>
                                <button type="button" @click="open = false"
                                    class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-semibold"
                                    aria-label="Cancelar borrado">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <a href="{{ route('private-profile') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 py-4 px-8 rounded-lg shadow-lg hover:from-gray-300 hover:to-gray-400 font-bold text-lg transition-all duration-200 text-center focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 border border-gray-300"
                aria-label="Cancelar y volver al perfil privado">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 mr-2">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                </span>
                Cancelar
            </a>
        </div>
    </div>
</div>
