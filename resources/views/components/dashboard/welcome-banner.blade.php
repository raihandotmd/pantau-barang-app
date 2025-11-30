@props(['status'])
<div class="bg-pantau-dark rounded-lg p-8 text-white relative overflow-hidden">
    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <h1 class="text-xl font-bold">Selamat Datang di Platform Multi-Vendor Pantau Barang</h1>
        </div>
        <p class="text-pantau-sand max-w-3xl mb-4">
            Anda adalah bagian dari ekosistem platform multi-vendor Pantau Barang. Kelola toko, produk, dan pesanan Anda dengan mudah melalui dashboard ini.
        </p>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pantau-medium text-white">
            Status: {{ $status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
        </span>
    </div>
</div>
