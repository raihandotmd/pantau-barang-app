@props(['store'])

<div x-data="{ open: false }" @open-store-detail-{{ $store->id }}.window="open = true">
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Detail Toko: {{ $store->name }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Toko</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $store->name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $store->slug }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kontak</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $store->contact_info }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $store->status === 'active' ? 'bg-green-100 text-green-800' : 
                                               ($store->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($store->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $store->address }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $store->description }}</p>
                                </div>

                                @if($store->location)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                    <div id="map-{{ $store->id }}" style="height: 300px;" class="w-full rounded-lg border border-gray-300"></div>
                                </div>
                                @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                    <p class="mt-1 text-sm text-gray-500 italic">Lokasi tidak tersedia</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('storeDetailMap{{ $store->id }}', () => ({
                init() {
                    @if($store->location)
                    this.$watch('open', value => {
                        if (value) {
                            setTimeout(() => {
                                this.initMap();
                            }, 100);
                        }
                    });
                    @endif
                },
                initMap() {
                    @if($store->location)
                    const mapId = 'map-{{ $store->id }}';
                    const lat = {{ $store->location->getLatitude() }};
                    const lng = {{ $store->location->getLongitude() }};
                    
                    if (document.getElementById(mapId)) {
                        // Check if map is already initialized
                        if (L.DomUtil.get(mapId)._leaflet_id) {
                            return;
                        }

                        const map = L.map(mapId).setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        
                        L.marker([lat, lng]).addTo(map)
                            .bindPopup('{{ $store->name }}')
                            .openPopup();
                            
                        // Fix map rendering issues in modal
                        setTimeout(() => {
                            map.invalidateSize();
                        }, 200);
                    }
                    @endif
                }
            }));
        });
    </script>
    
    <!-- Initialize Alpine component for this specific store -->
    <div x-data="storeDetailMap{{ $store->id }}"></div>
</div>
