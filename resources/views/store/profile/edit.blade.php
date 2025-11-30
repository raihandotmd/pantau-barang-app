<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Profil Toko') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Kembali ke Dashboard') }}
            </a>
        </div>
    </x-slot>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Leaflet Locate Control -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('store-profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Banner Image -->
                        <div>
                            <x-input-label for="banner_image" :value="__('Banner Toko (Opsional)')" />
                            
                            @if($store->banner_image)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $store->banner_image) }}" alt="Current Banner" class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif

                            <input id="banner_image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="banner_image" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            <x-input-error :messages="$errors->get('banner_image')" class="mt-2" />
                        </div>

                        <!-- Store Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Toko')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $store->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Slug -->
                        <div>
                            <x-input-label for="slug" :value="__('Slug URL')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $store->slug)" required />
                            <p class="mt-1 text-sm text-gray-500">URL unik untuk toko Anda (contoh: nama-toko-anda)</p>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium rounded-md shadow-sm" rows="4">{{ old('description', $store->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <x-input-label for="contact_info" :value="__('Kontak Info')" />
                            <x-text-input id="contact_info" class="block mt-1 w-full" type="text" name="contact_info" :value="old('contact_info', $store->contact_info)" required />
                            <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium rounded-md shadow-sm" rows="3" required>{{ old('address', $store->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Location Map -->
                        <div>
                            <x-input-label for="map" :value="__('Lokasi Toko')" />
                            <div id="map" style="height: 400px; width: 100%;" class="w-full rounded-lg border border-gray-300 mt-1 z-0"></div>
                            <p class="mt-1 text-sm text-gray-500">Cari lokasi atau gunakan tombol GPS untuk menentukan lokasi toko Anda.</p>
                            
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $store->location ? $store->location->getLatitude() : '') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $store->location ? $store->location->getLongitude() : '') }}">
                            
                            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

                            @if (session('success'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ session('success') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial coordinates (default to Jakarta if not set)
            const defaultLat = -6.2088;
            const defaultLng = 106.8456;
            
            const currentLat = parseFloat(document.getElementById('latitude').value) || defaultLat;
            const currentLng = parseFloat(document.getElementById('longitude').value) || defaultLng;

            const map = L.map('map').setView([currentLat, currentLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Fix map rendering issues
            setTimeout(() => {
                map.invalidateSize();
            }, 200);

            let marker;

            // Add marker if location exists
            if (document.getElementById('latitude').value) {
                marker = L.marker([currentLat, currentLng], {draggable: true}).addTo(map);
            }

            // Update inputs when marker is dragged
            function updateInputs(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }

            if (marker) {
                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    updateInputs(position.lat, position.lng);
                });
            }

            // Click map to set location
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, {draggable: true}).addTo(map);
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateInputs(position.lat, position.lng);
                    });
                }
                updateInputs(lat, lng);
            });

            // Add Search Control
            L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                const bbox = e.geocode.bbox;
                const poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                map.fitBounds(poly.getBounds());
                
                const center = poly.getBounds().getCenter();
                
                if (marker) {
                    marker.setLatLng(center);
                } else {
                    marker = L.marker(center, {draggable: true}).addTo(map);
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateInputs(position.lat, position.lng);
                    });
                }
                updateInputs(center.lat, center.lng);
            })
            .addTo(map);

            // Add Locate Control (GPS)
            L.control.locate({
                position: 'topleft',
                strings: {
                    title: "Gunakan lokasi saya"
                },
                locateOptions: {
                    enableHighAccuracy: true
                },
                onLocationError: function(err) {
                    alert(err.message);
                }
            }).addTo(map);

            // Handle location found event from locate control
            map.on('locationfound', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, {draggable: true}).addTo(map);
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateInputs(position.lat, position.lng);
                    });
                }
                updateInputs(lat, lng);
            });
        });
    </script>
</x-app-layout>
