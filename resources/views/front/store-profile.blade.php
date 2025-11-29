<x-front-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    <x-front.navbar :store="$store" :transparent="false" />

    <div class="pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Banner Image -->
            <div class="relative h-64 w-full bg-gray-200">
                @if($store->banner_image)
                    <img src="{{ Storage::url($store->banner_image) }}" alt="Store Banner" class="h-full w-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Default Banner" class="h-full w-full object-cover">
                @endif
                
            </div>

            <div class="pt-8 pb-8 px-8 sm:px-12">
                <div class="flex flex-col gap-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ strtoupper($store->name) }}</h1>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Left Column: Description & Contact -->
                        <div class="lg:col-span-1 space-y-8">
                            <div class="prose prose-indigo text-gray-600 max-w-none">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tentang Toko</h3>
                                <p>{{ $store->description ?? 'Deskripsi toko belum tersedia.' }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Kontak Kami
                                </h3>
                                <ul class="space-y-4 text-gray-600">
                                    <li class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-6 pt-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="block font-medium text-gray-900">Alamat</span>
                                            <span class="block text-sm">{{ $store->address }}</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-6 pt-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="block font-medium text-gray-900">Kontak</span>
                                            <span class="block text-sm">{{ $store->contact_info ?? '-' }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Right Column: Map -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                Lokasi Toko
                            </h3>
                            <div id="store-profile-map" class="h-[500px] w-full rounded-xl border border-gray-200 shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-front.footer :store="$store" />

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $store->location ? $store->location->getLatitude() : -6.200000 }};
                const lng = {{ $store->location ? $store->location->getLongitude() : 106.816666 }};
                
                const map = L.map('store-profile-map').setView([lat, lng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup('{{ $store->name }}')
                    .openPopup();
            });
        </script>
    @endpush
</x-front-layout>
