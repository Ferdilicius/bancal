@section('title', $addressId ? 'Editar Bancal' : 'Crear Bancal')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
@endsection

<div class="max-w-6xl mx-auto py-6 px-6 sm:px-12 text-lg">
    <a href="{{ route('private.profile') }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
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
                        let layers = L.geoJSON(geo).getLayers();
                        if (layers.length > 0) {
                            let layer = layers[0];
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
                        }
                    } catch (e) {
                        console.error('Error parsing geometry or adding to map:', e);
                    }
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
        <h1 id="address-form-title" class="text-2xl font-bold text-indigo-700 mb-10 text-center">
            {{ $addressId ? 'Editar Bancal' : 'Crear Bancal' }}
        </h1>
        <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">
            {{-- Nombre --}}
            <div>
                <label for="name" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Nombre
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el nombre">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Escribe un nombre identificativo para el bancal o dirección.
                        </div>
                    </span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                @error('name')
                    <span class="text-sm text-red-500 mt-2 block">{{ str_replace('name', 'nombre', $message) }}</span>
                @enderror
            </div>

            {{-- Dirección --}}
            <div>
                <label for="address" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    Dirección
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre la dirección">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Puedes añadir una dirección descriptiva o referencia para localizar el bancal.
                        </div>
                    </span>
                </label>
                <input type="text" id="address" wire:model="address"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                @error('address')
                    <span class="text-sm text-red-500 mt-2 block"
                        role="alert">{{ str_replace('address', 'dirección', $message) }}</span>
                @enderror
            </div>

            {{-- Tipo de direccion/bancal --}}
            <div>
                <label for="address_type_id" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Tipo de bancal
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el tipo de bancal">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Selecciona el tipo que mejor describa el bancal o dirección.
                        </div>
                    </span>
                </label>
                <select id="address_type_id" wire:model="address_type_id"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                    <option value="" selected>Selecciona un tipo</option>
                    @foreach ($addressTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('address_type_id')
                    <span class="text-sm text-red-500 mt-2 block"
                        role="alert">{{ str_replace('address_type_id', 'tipo de bancal', $message) }}</span>
                @enderror
            </div>

            {{-- Mapa --}}
            <div>
                <label class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    Ubicación en el mapa
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el mapa">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Dibuja el área del bancal o marca su ubicación en el mapa para mayor precisión.
                        </div>
                    </span>
                </label>
                <div id="map" class="w-full h-72 rounded border border-gray-300"></div>
            </div>

            {{-- Imágenes --}}
            <div>
                <label for="images-upload" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-3">
                    Imágenes de la dirección
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre las imágenes de la dirección">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Añade imágenes claras y representativas del bancal para una mejor identificación.
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
                    <span
                        class="text-sm text-red-500 mt-2 block">{{ str_replace(['images', 'The'], ['imágenes', 'La'], $message) }}</span>
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
                                    <img src="{{ $image->temporaryUrl() }}"
                                        class="object-cover w-full h-full rounded" style="width: 100%; height: 100%;"
                                        alt="Imagen nueva {{ $key + 1 }}">
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
            <div>
                <label class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Estado
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el estado">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Indica si el bancal está activo (disponible) o inactivo (no disponible).
                        </div>
                    </span>
                </label>
                <div class="flex items-center gap-12" role="radiogroup" aria-label="Estado de la dirección">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="1"
                            class="form-radio w-5 h-5 text-green-600 focus:ring-green-500"
                            aria-checked="{{ $status == 1 ? 'true' : 'false' }}" aria-label="Activo" />
                        <span class="text-base font-bold">Activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="0"
                            class="form-radio w-5 h-5 text-red-600 focus:ring-red-500"
                            aria-checked="{{ $status == 0 ? 'true' : 'false' }}" aria-label="Inactivo" />
                        <span class="text-base font-bold">Inactivo</span>
                    </label>
                </div>
                @error('status')
                    <span class="text-sm text-red-500 mt-2 block"
                        role="alert">{{ str_replace('status', 'estado', $message) }}</span>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-12">
                <button type="button" @click="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded shadow hover:bg-indigo-700 font-bold text-lg transition"
                    aria-label="{{ $addressId ? 'Actualizar Bancal' : 'Crear Bancal' }}">
                    <i class="fas fa-save mr-2" aria-hidden="true"></i>
                    {{ $addressId ? 'Actualizar Bancal' : 'Crear Bancal' }}
                </button>
                @if ($addressId)
                    <div x-data="{ open: false }" class="flex-1">
                        <button type="button" @click="open = true"
                            class="w-full bg-red-600 text-white py-3 px-6 rounded shadow hover:bg-red-700 text-lg font-bold"
                            style="z-index:1;" aria-label="Borrar Dirección">
                            <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Borrar Dirección
                        </button>
                        <!-- Modal de confirmación -->
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                            role="dialog" aria-modal="true" aria-labelledby="modal-title">
                            <div class="bg-white rounded shadow p-8 max-w-xs w-full text-center"
                                @click.away="open = false" @keydown.escape.window="open = false">
                                <h2 id="modal-title" class="text-lg font-bold mb-4 text-gray-900">¿Seguro que quieres
                                    borrar esta dirección?
                                </h2>
                                <p class="mb-6 text-gray-600 text-base">Esta acción es irreversible y no podrás
                                    recuperarla.</p>
                                <div class="flex gap-4 justify-center">
                                    <button type="button" wire:click="delete"
                                        class="bg-red-700 text-white px-6 py-3 rounded hover:bg-red-800 font-semibold text-base"
                                        aria-label="Confirmar borrado">
                                        <i class="fas fa-trash-alt mr-2" aria-hidden="true"></i> Sí, borrar
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="bg-gray-200 text-gray-800 px-6 py-3 rounded hover:bg-gray-300 font-semibold text-base"
                                        aria-label="Cancelar borrado">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('private.profile') }}"
                    class="flex-1 flex items-center justify-center gap-3 bg-gray-100 text-gray-700 py-3 px-6 rounded shadow hover:bg-gray-200 font-bold text-lg transition border border-gray-300"
                    aria-label="Cancelar y volver al perfil privado">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div>
