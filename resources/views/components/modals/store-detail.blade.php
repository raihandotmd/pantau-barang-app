@props(['store'])

<div x-data="{ open: false }" @open-store-detail-{{ $store->id }}.window="open = true">
    <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                
                <!-- Modal Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $store->name }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $store->slug }}</p>
                    </div>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        {{ $store->status === 'active' ? 'bg-green-100 text-green-800' : 
                           ($store->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($store->status) }}
                    </span>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    @if($store->banner_image)
                        <div class="mb-6 rounded-xl overflow-hidden h-48 w-full relative">
                            <img src="{{ Storage::url($store->banner_image) }}" alt="{{ $store->name }} Banner" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Left Column: Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Kontak</label>
                                <div class="mt-1 flex items-center text-gray-900">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $store->contact_info }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Alamat</label>
                                <div class="mt-1 flex items-start text-gray-900">
                                    <svg class="w-4 h-4 mr-2 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $store->address }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-600 leading-relaxed">{{ $store->description ?: 'Tidak ada deskripsi.' }}</p>
                            </div>
                        </div>

                        <!-- Right Column: Map -->
                        <div class="h-full min-h-[200px] bg-gray-50 rounded-xl overflow-hidden border border-gray-200 relative">
                            @if($store->location)
                                <div id="map-{{ $store->id }}" class="absolute inset-0 w-full h-full"></div>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    <span class="text-sm">Lokasi tidak tersedia</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Footer / Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-gray-100">
                    <div class="flex-1 w-full sm:w-auto">
                        <form action="{{ route('super-admin.stores.approve', $store) }}" method="POST" x-data="{ newStatus: '{{ $store->status }}' }">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" x-model="newStatus">
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700">Ubah Status:</span>
                                <div class="relative flex items-center">
                                    <select x-model="newStatus" 
                                        class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-10 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:border-pantau-medium sm:text-sm font-medium transition-shadow cursor-pointer hover:border-gray-400">
                                        <option value="pending">Pending</option>
                                        <option value="active">Active</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                
                                <button type="submit" 
                                    x-show="newStatus !== '{{ $store->status }}'"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status toko ini?')" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-pantau-medium hover:bg-pantau-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pantau-medium shadow-sm">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                    <button type="button" @click="open = false" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pantau-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('storeDetailMap{{ $store->id }}', () => ({
                map: null,
                init() {
                    @if($store->location)
                    this.$watch('open', value => {
                        if (value) {
                            this.$nextTick(() => {
                                this.initMap();
                            });
                        }
                    });
                    @endif
                },
                initMap() {
                    @if($store->location)
                    const mapId = 'map-{{ $store->id }}';
                    const lat = {{ $store->location->getLatitude() }};
                    const lng = {{ $store->location->getLongitude() }};
                    
                    if (!document.getElementById(mapId)) return;

                    if (!this.map) {
                        this.map = L.map(mapId).setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(this.map);
                        
                        L.marker([lat, lng]).addTo(this.map)
                            .bindPopup('{{ $store->name }}')
                            .openPopup();
                    }
                    
                    // Always invalidate size when opening modal to fix rendering issues
                    setTimeout(() => {
                        this.map.invalidateSize();
                    }, 200);
                    @endif
                }
            }));
        });
    </script>
    
    <!-- Initialize Alpine component for this specific store -->
    <div x-data="storeDetailMap{{ $store->id }}"></div>
</div>
