<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Penjual') }}
                </h2>
                <p class="text-sm text-gray-500">{{ Auth::user()->store->name }}</p>
            </div>
            <!-- Logout is handled by navigation, but we can add a button here if needed per design -->
        </div>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: 'inventaris' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gray-900 rounded-lg p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <h1 class="text-xl font-bold">Selamat Datang di Platform Multi-Vendor Pantau Barang</h1>
                    </div>
                    <p class="text-gray-300 max-w-3xl mb-4">
                        Anda adalah bagian dari ekosistem penjual spareparts motor terbesar di Jakarta Timur. Kelola toko, produk, dan pesanan Anda dengan mudah melalui dashboard ini.
                    </p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-600 text-white">
                        Status: Aktif
                    </span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Produk -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 font-medium">Total Barang</span>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="text-3xl font-bold text-blue-600 mb-1">{{ $totalItems }}</div>
                </div>

                <!-- Pesanan Pending -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 font-medium">Pesanan Pending</span>
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-3xl font-bold text-orange-600 mb-1">{{ $pendingOrders }}</div>
                    <div class="text-sm text-gray-500">Menunggu diproses</div>
                </div>

                <!-- Stok Rendah -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 font-medium">Stok Rendah</span>
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="text-3xl font-bold text-red-600 mb-1">{{ $lowStockCount }}</div>
                    <div class="text-sm text-gray-500">Perlu restock</div>
                </div>

                <!-- Revenue -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-gray-500 font-medium">Revenue</span>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div class="text-2xl font-bold text-green-600 mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-500">Total penjualan (kotor)</div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-gray-100 p-1 rounded-lg inline-flex">
                <button @click="activeTab = 'inventaris'" :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'inventaris', 'text-gray-500 hover:text-gray-700': activeTab !== 'inventaris' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventaris
                </button>
                <button @click="activeTab = 'kategori'" :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'kategori', 'text-gray-500 hover:text-gray-700': activeTab !== 'kategori' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori
                </button>
                <button @click="activeTab = 'pesanan'" :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'pesanan', 'text-gray-500 hover:text-gray-700': activeTab !== 'pesanan' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Pesanan
                </button>
                <button @click="activeTab = 'riwayat'" :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'riwayat', 'text-gray-500 hover:text-gray-700': activeTab !== 'riwayat' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Stok
                </button>
                <button @click="activeTab = 'laporan'" :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'laporan', 'text-gray-500 hover:text-gray-700': activeTab !== 'laporan' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Analisis
                </button>
            </div>

            <!-- Tab Content: Inventaris -->
            <div x-show="activeTab === 'inventaris'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Manajemen Inventaris</h3>
                        <p class="text-sm text-gray-500">Kelola stok spareparts</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('items.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>

                <!-- Search (Visual Only for MVP) -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $item->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap {{ $item->quantity <= 10 ? 'text-red-600 font-bold' : 'text-gray-900' }}">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->quantity == 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                                        @elseif($item->quantity <= 10)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Stok Rendah</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('items.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>

            <!-- Tab Content: Kategori -->
            <div x-show="activeTab === 'kategori'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6" style="display: none;">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Kelola Kategori</h3>
                        <p class="text-sm text-gray-500">Atur kategori barang Anda</p>
                    </div>
                    <div class="flex gap-2">
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-category')" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Buat Kategori
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Pada</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $category->items_count }} Barang</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $category->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>

            <!-- Tab Content: Pesanan -->
            <div x-show="activeTab === 'pesanan'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6" style="display: none;">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 text-right">
                        <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua Pesanan &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Riwayat Stok -->
            <div x-show="activeTab === 'riwayat'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6" style="display: none;">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Pergerakan Stok</h3>
                    <a href="{{ route('stock-movements.create') }}" class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Catat Pergerakan
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentMovements as $movement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $movement->item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($movement->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->quantity_change }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Content: Laporan -->
            <div x-show="activeTab === 'laporan'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6" style="display: none;">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Laporan Stok</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Stok Masuk (7 Hari)</p>
                        <p class="text-3xl font-bold text-green-600">+{{ $stockInLast7Days }}</p>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Stok Keluar (7 Hari)</p>
                        <p class="text-3xl font-bold text-red-600">-{{ $stockOutLast7Days }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-4">Peta Sebaran Pesanan</h3>
                <div id="dashboard-map" class="h-96 w-full rounded border border-gray-300"></div>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map only when tab is shown or immediately but handle resize
            // Center on Indonesia (approx -2.5, 118) with zoom 5
            var map = L.map('dashboard-map').setView([-2.5489, 118.0149], 5);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var locations = @json($orderLocations);
            
            locations.forEach(function(loc) {
                L.marker([loc.lat, loc.lng])
                    .addTo(map)
                    .bindPopup('<b>Order #' + loc.id + '</b><br>' + loc.name + '<br>Status: ' + loc.status);
            });

            if (locations.length > 0) {
                var group = new L.featureGroup(locations.map(loc => L.marker([loc.lat, loc.lng])));
                map.fitBounds(group.getBounds().pad(0.1));
            }

            // Fix map rendering when tab is switched
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
            
            // Watch for tab changes to invalidate map size
            // Since we use Alpine, we can hook into x-effect or just rely on click
            document.querySelector('[@click="activeTab = \'laporan\'"]').addEventListener('click', function() {
                setTimeout(function() {
                    map.invalidateSize();
                    if (locations.length > 0) {
                        var group = new L.featureGroup(locations.map(loc => L.marker([loc.lat, loc.lng])));
                        map.fitBounds(group.getBounds().pad(0.1), { maxZoom: 15 });
                    }
                }, 100);
            });
        });
    </script>
    <!-- Modals -->
    <x-modal name="create-category" :show="$errors->has('name')" focusable>
        <x-forms.category-create />
    </x-modal>

</x-app-layout>
