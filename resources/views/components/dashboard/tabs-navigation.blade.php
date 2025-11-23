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
