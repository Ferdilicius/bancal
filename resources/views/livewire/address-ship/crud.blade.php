@section('title', $addressId ? 'Editar Dirección de envío' : 'Crear Dirección de envío')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
@endsection

<div class="max-w-6xl mx-auto py-6 px-6 sm:px-12 text-lg">
    @php
        $previousUrl = url()->previous();
        $currentUrl = url()->current();

        if ($previousUrl === $currentUrl && request()->headers->has('referer')) {
            $previousUrl = request()->headers->get('referer');
        }
    @endphp
    <a href="{{ $previousUrl }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
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
                                    style: { color: '#bbb', fillColor: '#ddd', fillOpacity: 0.2, weight: 2 }
                                }).addTo(this.map);
                                // Si es un punto, pon un marcador gris apagado
                                if (geo.type === 'Point' || (geo.geometry && geo.geometry.type === 'Point')) {
                                    let coords = geo.coordinates || (geo.geometry ? geo.geometry.coordinates : null);
                                    if (coords) {
                                        L.marker([coords[1], coords[0]], {
                                            icon: L.icon({
                                                iconUrl: 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-grey.png',
                                                iconSize: [25, 41],
                                                iconAnchor: [12, 41],
                                                popupAnchor: [1, -34],
                                                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                                                shadowSize: [41, 41]
                                            })
                                        }).addTo(this.map).bindTooltip(addr.name, { permanent: false });
                                    }
                                } else if (addr.name) {
                                    layer.bindTooltip(addr.name, { permanent: false });
                                }
                            } catch (e) {}
                        }
                    });
                }
    
                // Si ya hay marcador guardado, lo mostramos y permitimos editar
                if ($wire.geometry) {
                    try {
                        let geo = JSON.parse($wire.geometry);
                        drawnItems.clearLayers();
                        let layers = L.geoJSON(geo).getLayers();
                        if (layers.length > 0) {
                            let layer = layers[0];
                            drawnItems.addLayer(layer);
                            this.drawnLayer = layer;
                            this.map.fitBounds(layer.getBounds ? layer.getBounds() : layer.getLatLng().toBounds(500));
    
                            // Añadir marcador SOLO para la address actual
                            if (layer.getLatLng) {
                                let latlng = layer.getLatLng();
                                this.marker = L.marker(latlng, {
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
    
                // Control de dibujo SOLO para marcador
                let drawControl = new L.Control.Draw({
                    draw: {
                        marker: true,
                        polygon: false,
                        rectangle: false,
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
    
                // Evento al crear marcador
                this.map.on(L.Draw.Event.CREATED, (e) => {
                    drawnItems.clearLayers();
                    this.drawnLayer = e.layer;
                    drawnItems.addLayer(this.drawnLayer);
                    $wire.set('geometry', JSON.stringify(this.drawnLayer.toGeoJSON()));
    
                    // Actualiza lat/lng en Livewire
                    if (this.drawnLayer.getLatLng) {
                        let latlng = this.drawnLayer.getLatLng();
                        $wire.set('latitude', latlng.lat);
                        $wire.set('longitude', latlng.lng);
    
                        // Actualiza el marcador
                        if (this.marker) this.map.removeLayer(this.marker);
                        this.marker = L.marker(latlng, {
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
    
                // Evento al editar marcador
                this.map.on(L.Draw.Event.EDITED, (e) => {
                    e.layers.eachLayer((layer) => {
                        this.drawnLayer = layer;
                        $wire.set('geometry', JSON.stringify(layer.toGeoJSON()));
    
                        if (layer.getLatLng) {
                            let latlng = layer.getLatLng();
                            $wire.set('latitude', latlng.lat);
                            $wire.set('longitude', latlng.lng);
    
                            this.map.setView(latlng, 13);
                            // Actualiza el marcador
                            if (this.marker) this.map.removeLayer(this.marker);
                            this.marker = L.marker(latlng, {
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
    
                // Evento al borrar marcador
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
            {{ $addressId ? 'Editar Dirección de envío' : 'Crear Dirección de envío' }}
        </h1>
        <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">
            {{-- Nombre --}}
            <div class="mb-6">
                <label for="name" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-2">
                    <span class="text-red-600">*</span>
                    Nombre
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el nombre">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            El nombre es una etiqueta para identificar fácilmente esta dirección (por ejemplo: "Casa",
                            "Oficina", etc.).
                        </div>
                    </span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-2 block w-64 border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400"
                    aria-required="true">
                @error('name')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('name', 'nombre', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Dirección --}}
            <div class="mb-6">
                <label for="address" class="flex text-base font-semibold text-gray-800 mb-2 items-center gap-2">
                    <span class="text-red-600">*</span>
                    Dirección
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre la dirección">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Escribe la dirección completa donde se realizará el envío (calle, número, piso, ciudad,
                            etc.).
                        </div>
                    </span>
                </label>
                <input type="text" id="address" wire:model="address"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400"
                    aria-required="true">
                @error('address')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('address', 'dirección', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Mapa --}}
            <div class="mb-8">
                <label class="block text-base font-semibold text-gray-800 mb-2">
                    <span class="text-red-600 pr-2">*</span>Ubicación en el mapa
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre la ubicación en el mapa">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Selecciona el punto exacto en el mapa donde se encuentra la dirección para facilitar la
                            entrega.
                        </div>
                    </span>
                </label>
                <div id="map" class="w-full h-72 rounded border border-gray-300"></div>
                @error('latitude')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('latitude', 'latitud', $message) }}
                    </span>
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
                <a href="{{ route('private.profile') }}"
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
