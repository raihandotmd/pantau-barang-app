@props(['stockInLast7Days', 'stockOutLast7Days'])

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
