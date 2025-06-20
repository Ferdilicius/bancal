@section('title', $addressId ? 'Editar Bancal' : 'Crear Bancal')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
@endsection

<div class="max-w-6xl mx-auto py-16 px-6 sm:px-12 text-lg">
    <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div x-data="{
        latitude: $wire.latitude ?? 40.4168,
        longitude: $wire.longitude ?? -3.7038,
        map: null,
        marker: null,
        drawnLayer: null,
        otherAddresses: @js($otherAddresses->map(fn($a) => ['geometry' => $a->geometry, 'name' => $a->name])->values()),
        submit() { $wire.save() },
        initMap() {
            let waitForLeaflet = () => {
                if (typeof L === 'undefined' || typeof L.Draw === 'undefined' || !document.getElementById('map')) {
                    setTimeout(waitForLeaflet, 100);
                    return;
                }
                if (this.map) {
                    this.map.off();
                    this.map.remove();
                    this.map = null;
                    this.marker = null;
                    this.drawnLayer = null;
                }
    
                this.map = L.map('map').setView([this.latitude, this.longitude], 13);
    
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(this.map);
    
                // Dibujo
                let drawnItems = new L.FeatureGroup();
                this.map.addLayer(drawnItems);
    
                // Mostrar addresses del usuario (solo visualización, SIN puntero)
                if (this.otherAddresses && this.otherAddresses.length > 0) {
                    this.otherAddresses.forEach(addr => {
                        if (addr.geometry) {
                            try {
                                let geo = typeof addr.geometry === 'string' ? JSON.parse(addr.geometry) : addr.geometry;
                                let layer = L.geoJSON(geo, {
                                    style: { color: '#888', fillColor: '#bbb', fillOpacity: 0.3, weight: 2 }
                                }).addTo(this.map);
                                if (addr.name) {
                                    layer.bindTooltip(addr.name, { permanent: false });
                                }
                                // Ya NO se añade marcador para los otros addresses
                            } catch (e) {}
                        }
                    });
                }
    
                // Si ya hay geometría guardada, la mostramos y permitimos editar
                if ($wire.geometry) {
                    try {
                        let geo = JSON.parse($wire.geometry);
                        drawnItems.clearLayers();
                        let layer = L.geoJSON(geo).getLayers()[0];
                        drawnItems.addLayer(layer);
                        this.drawnLayer = layer;
                        this.map.fitBounds(layer.getBounds());
    
                        // Añadir marcador SOLO para la address actual (centroide)
                        if (layer.getBounds && layer.getBounds().isValid()) {
                            let center = layer.getBounds().getCenter();
                            this.marker = L.marker(center, {
                                icon: L.icon({
                                    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                                    iconSize: [25, 41],
                                    iconAnchor: [12, 41],
                                    popupAnchor: [1, -34],
                                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                                    shadowSize: [41, 41]
                                })
                            }).addTo(this.map).bindPopup('Ubicación actual').openPopup();
                        }
                    } catch (e) {}
                }
    
                // Control de dibujo SOLO para la address actual
                let drawControl = new L.Control.Draw({
                    draw: {
                        polygon: true,
                        rectangle: true,
                        marker: false,
                        circle: false,
                        polyline: false,
                        circlemarker: false
                    },
                    edit: {
                        featureGroup: drawnItems,
                        edit: true,
                        remove: true
                    }
                });
                this.map.addControl(drawControl);
    
                // Evento al crear forma
                this.map.on(L.Draw.Event.CREATED, (e) => {
                    drawnItems.clearLayers();
                    this.drawnLayer = e.layer;
                    drawnItems.addLayer(this.drawnLayer);
                    $wire.set('geometry', JSON.stringify(this.drawnLayer.toGeoJSON()));
    
                    // Calcula el centroide y actualiza lat/lng en Livewire
                    if (this.drawnLayer.getBounds) {
                        let center = this.drawnLayer.getBounds().getCenter();
                        $wire.set('latitude', center.lat);
                        $wire.set('longitude', center.lng);
    
                        // Actualiza el marcador al centroide de la nueva figura
                        if (this.marker) this.map.removeLayer(this.marker);
                        this.marker = L.marker(center, {
                            icon: L.icon({
                                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                                shadowSize: [41, 41]
                            })
                        }).addTo(this.map).bindPopup('Ubicación actual').openPopup();
                    }
                });
    
                // Evento al editar forma
                this.map.on(L.Draw.Event.EDITED, (e) => {
                    e.layers.eachLayer((layer) => {
                        this.drawnLayer = layer;
                        $wire.set('geometry', JSON.stringify(layer.toGeoJSON()));
    
                        if (layer.getBounds) {
                            let center = layer.getBounds().getCenter();
                            $wire.set('latitude', center.lat);
                            $wire.set('longitude', center.lng);
    
                            this.map.fitBounds(layer.getBounds());
                            // Actualiza el marcador al centroide de la figura editada
                            if (this.marker) this.map.removeLayer(this.marker);
                            this.marker = L.marker(center, {
                                icon: L.icon({
                                    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                                    iconSize: [25, 41],
                                    iconAnchor: [12, 41],
                                    popupAnchor: [1, -34],
                                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                                    shadowSize: [41, 41]
                                })
                            }).addTo(this.map).bindPopup('Ubicación actual').openPopup();
                        }
                    });
                });
    
                // Evento al borrar forma
                this.map.on(L.Draw.Event.DELETED, (e) => {
                    this.drawnLayer = null;
                    $wire.set('geometry', null);
                    $wire.set('latitude', null);
                    $wire.set('longitude', null);
                    if (this.marker) {
                        this.map.removeLayer(this.marker);
                        this.marker = null;
                    }
                    this.map.setView([this.latitude, this.longitude], 13);
                });
    
                setTimeout(() => { this.map.invalidateSize(); }, 300);
            };
            waitForLeaflet();
        }
    }" x-init="initMap()"
        class="mx-auto p-12 bg-white shadow-lg rounded-lg border border-gray-200" role="form"
        aria-labelledby="address-form-title">
        <h1 id="address-form-title" class="text-3xl font-bold text-indigo-700 mb-10 text-center">
            {{ $addressId ? 'Editar Bancal' : 'Crear Bancal' }}
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
            </div>

            {{-- Imágenes
            <div class="mb-8" x-data="{ dragIndex: null }">
                <label for="images-upload"
                    class="block text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
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
                                @dragover.prevent
                                @drop="$wire.moveImage(dragIndex, {{ $key }}); dragIndex = null"
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
            </div> --}}

            {{-- Imágenes --}}
            <div>
                <label for="images-upload" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                    Imágenes de la dirección
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre las imágenes de la dirección">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Añade imágenes claras y representativas de la dirección para una mejor identificación.
                        </div>
                    </span>
                </label>
                <label for="images-upload" class="block w-full cursor-pointer mb-3">
                    <input id="images-upload" type="file" wire:model="newImages" multiple
                        accept="image/png, image/jpeg, image/jpg, image/webp, image/gif" class="hidden" />
                    <span
                        class="inline-block bg-indigo-50 text-indigo-700 font-semibold text-base px-5 py-3 rounded border border-gray-300 hover:bg-indigo-100 transition">
                        Seleccionar imágenes
                    </span>
                </label>
                @error('images.*')
                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                @enderror

                @if ($images && count($images) > 0)
                    <div class="mt-4 flex flex-wrap gap-4" x-data="{
                        dragging: null,
                        dragOver: null,
                        startDrag(index) { this.dragging = index },
                        endDrag() {
                            this.dragging = null;
                            this.dragOver = null
                        },
                        onDrop(index) {
                            if (this.dragging !== null && this.dragging !== index) {
                                $wire.moveImage(this.dragging, index);
                            }
                            this.endDrag();
                        }
                    }">
                        @foreach ($images as $key => $image)
                            @php
                                $imageId = null;
                                if (is_string($image) && isset($addressModel)) {
                                    $imgModel = $addressModel->images->where('path', $image)->first();
                                    $imageId = $imgModel ? $imgModel->id : null;
                                }
                            @endphp
                            <div class="relative group flex items-center justify-center bg-gray-100 border border-indigo-200 rounded shadow"
                                style="width: 180px; height: 180px;" draggable="true"
                                @dragstart="startDrag({{ $key }})" @dragend="endDrag()"
                                @dragover.prevent="dragOver = {{ $key }}" @dragleave="dragOver = null"
                                @drop.prevent="onDrop({{ $key }})"
                                :class="{
                                    'ring-2 ring-indigo-400': dragOver === {{ $key }},
                                    'opacity-60': dragging === {{ $key }}
                                }">
                                @if ($imageId)
                                    <img src="{{ route('address.image', ['addressId' => $addressModel->id, 'imageId' => $imageId]) }}"
                                        class="object-cover w-full h-full rounded" style="width: 100%; height: 100%;"
                                        alt="Imagen de la dirección {{ $key + 1 }}">
                                @elseif (is_object($image) && method_exists($image, 'temporaryUrl'))
                                    <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full rounded"
                                        style="width: 100%; height: 100%;" alt="Imagen nueva {{ $key + 1 }}">
                                @endif
                                <button type="button" wire:click="removeImage({{ $key }})"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-base font-bold shadow hover:bg-red-700 transition"
                                    title="Quitar imagen {{ $key + 1 }}">
                                    <i class="fas fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Arrastra y suelta las imágenes para reordenarlas.</p>
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
</div>
