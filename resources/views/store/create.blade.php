<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Your Store') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg mb-8">
                <div class="p-8 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold">Welcome to Your Store Setup!</h3>
                            <p class="text-blue-100 mt-2">Let's create your store and start managing your inventory.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('store.store') }}" class="space-y-6">
                        @csrf

                        <!-- Store Name -->
                        <div>
                            <x-input-label for="name" :value="__('Store Name')" class="text-lg font-medium" />
                            <x-text-input id="name"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                type="text" name="name" :value="old('name')" required autofocus
                                placeholder="Enter your store name" onkeyup="generateSlug()" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">This will be the main name of your store</p>
                        </div>

                        <!-- Store Slug -->
                        <div>
                            <x-input-label for="slug" :value="__('Store URL Slug')" class="text-lg font-medium" />
                            <div
                                class="mt-2 flex items-center bg-gray-50 border-2 border-gray-300 rounded-xl focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200 transition-all duration-200">
                                <span class="px-4 py-3 text-gray-500 font-medium">your-domain.com/</span>
                                <input id="slug" class="flex-1 py-3 px-2 bg-transparent border-0 focus:ring-0 text-lg"
                                    type="text" name="slug" value="{{ old('slug') }}" required placeholder="store-slug"
                                    pattern="^[a-z0-9]+(?:-[a-z0-9]+)*$" />
                            </div>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Auto-generated from store name, but you can customize
                                it</p>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <x-input-label for="contact_info" :value="__('Contact Information')"
                                class="text-lg font-medium" />
                            <x-text-input id="contact_info"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                type="text" name="contact_info" :value="old('contact_info')" required
                                placeholder="Phone number or email" />
                            <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Primary contact method for your store</p>
                        </div>

                        <!-- Store Location -->
                        <div>
                            <x-input-label for="location" :value="__('Store Location')" class="text-lg font-medium" />
                            <p class="text-sm text-gray-500 mb-2">Click on the map, use the search button (magnifying glass), or the GPS button to set your store location.</p>
                            
                            <!-- Map Container -->
                            <div id="map" class="h-96 w-full rounded-xl border-2 border-gray-300 z-0"></div>
                            
                            <!-- Hidden Inputs -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            
                            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Store Address')" class="text-lg font-medium" />
                            <textarea id="address"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                                name="address" rows="3"
                                placeholder="Enter your store's physical address (optional)">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Optional: Physical location of your store</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Store Description')"
                                class="text-lg font-medium" />
                            <textarea id="description"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                                name="description" rows="4"
                                placeholder="Describe what your store sells, your business model, etc. (optional)">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Optional: Brief description of your store</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Create My Store
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Secure</h4>
                            <p class="text-sm text-gray-600">Your data is protected</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Fast Setup</h4>
                            <p class="text-sm text-gray-600">Get started in minutes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Slug Generation -->
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Leaflet Locate Control -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <script>
        // Slug Generation
        function generateSlug() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            if (nameInput.value) {
                fetch('{{ route("store.generate-slug") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: nameInput.value
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        slugInput.value = data.slug;
                    })
                    .catch(error => {
                        console.error('Error generating slug:', error);
                    });
            } else {
                slugInput.value = '';
            }
        }

        // Add real-time slug validation
        document.getElementById('slug').addEventListener('input', function (e) {
            let value = e.target.value;
            // Convert to lowercase and replace invalid characters
            value = value.toLowerCase().replace(/[^a-z0-9-]/g, '').replace(/--+/g, '-');
            e.target.value = value;
        });

        // Map Logic
        let map, marker;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Default to Jakarta
            const defaultLat = -6.2088;
            const defaultLng = 106.8456;
            
            // Check for old input or default
            const oldLat = document.getElementById('latitude').value;
            const oldLng = document.getElementById('longitude').value;
            
            const startLat = oldLat ? parseFloat(oldLat) : defaultLat;
            const startLng = oldLng ? parseFloat(oldLng) : defaultLng;

            map = L.map('map').setView([startLat, startLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            if (oldLat && oldLng) {
                marker = L.marker([startLat, startLng]).addTo(map);
            }

            // Click handler
            map.on('click', function(e) {
                updateLocation(e.latlng.lat, e.latlng.lng);
            });

            // Add Geocoder Control (Search)
            const geocoder = L.Control.geocoder({
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
                
                updateLocation(e.geocode.center.lat, e.geocode.center.lng);
            })
            .addTo(map);

            // Add Locate Control (GPS)
            L.control.locate({
                position: 'topleft',
                strings: {
                    title: "Show me where I am"
                },
                locateOptions: {
                    enableHighAccuracy: true
                }
            }).addTo(map);

            // Handle location found event from Locate Control
            map.on('locationfound', function(e) {
                updateLocation(e.latlng.lat, e.latlng.lng);
            });
        });

        function updateLocation(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }
    </script>
</x-app-layout>
