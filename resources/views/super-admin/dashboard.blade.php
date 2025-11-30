<x-app-layout>



    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pengguna</div>
                            <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                        </div>
                        <div class="p-3 bg-pantau-sand/20 rounded-full">
                            <svg class="w-8 h-8 text-pantau-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Stores -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Toko</div>
                            <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $totalStores }}</div>
                        </div>
                        <div class="p-3 bg-pantau-sand/20 rounded-full">
                            <svg class="w-8 h-8 text-pantau-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Stores -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Toko Pending</div>
                            <div class="mt-2 text-3xl font-extrabold text-yellow-600">{{ $pendingStores }}</div>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Stores -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 transition-all hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Toko Aktif</div>
                            <div class="mt-2 text-3xl font-extrabold text-green-600">{{ $activeStores }}</div>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Management Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Manajemen Toko</h3>
                    
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('super-admin.dashboard') }}" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko atau slug..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-pantau-medium focus:ring-pantau-medium">
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-pantau-medium focus:ring-pantau-medium">
                                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-pantau-medium text-white rounded-md hover:bg-pantau-dark whitespace-nowrap">Cari</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Toko</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($stores as $store)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $store->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $store->contact_info }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $store->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($store->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($store->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $store->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <!-- Detail Button -->
                                                <button x-data @click="$dispatch('open-store-detail-{{ $store->id }}')" class="text-pantau-medium hover:text-pantau-dark" title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                @if($store->status === 'pending')
                                                    <!-- Approve Button -->
                                                    <form action="{{ route('super-admin.stores.approve', $store) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Apakah Anda yakin ingin menyetujui toko ini?')" title="Setujui">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <!-- Reject Button -->
                                                    <form action="{{ route('super-admin.stores.reject', $store) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menolak toko ini?')" title="Tolak">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            
                                            <!-- Include Modal -->
                                            <x-modals.store-detail :store="$store" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $stores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
