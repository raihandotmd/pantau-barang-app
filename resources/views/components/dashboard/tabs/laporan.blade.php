@props(['stockInLast7Days', 'stockOutLast7Days'])

<div x-show="activeTab === 'laporan'" style="display: none;">
    
    <!-- Laporan Stok -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Laporan Stok</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Stok Masuk -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium">Stok Masuk (7 Hari)</span>
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-green-600 mb-1">+{{ $stockInLast7Days }}</div>
                <div class="text-sm text-gray-500">Barang ditambahkan</div>
            </div>

            <!-- Stok Keluar -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium">Stok Keluar (7 Hari)</span>
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m0 0l4 4m-4-4l-4 4"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-red-600 mb-1">-{{ $stockOutLast7Days }}</div>
                <div class="text-sm text-gray-500">Barang keluar/terjual</div>
            </div>
        </div>
    </div>

    <!-- Peta Sebaran Pesanan -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 mb-4">Peta Sebaran Pesanan</h3>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
            <div id="dashboard-map" class="h-96 w-full rounded-lg z-0"></div>
        </div>
    </div>
</div>
