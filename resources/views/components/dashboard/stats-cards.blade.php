@props(['totalItems', 'pendingOrders', 'lowStockCount', 'totalRevenue'])

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
        <div class="text-sm text-gray-500">Perlu restock (kurang dari 10)</div>
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
