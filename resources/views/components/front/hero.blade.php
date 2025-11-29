@props(['store'])

<div class="relative bg-indigo-900 pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 to-indigo-800 mix-blend-multiply"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
            <span class="block text-4xl">welcome to,</span>
            <span class="block text-indigo-400">{{ strtoupper($store->name) }}</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-indigo-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            {{ $store->description ?? 'Pantau Barang menyediakan berbagai spareparts motor original dan berkualitas dengan harga terjangkau. Pengiriman cepat dan garansi produk tersedia.' }}
        </p>
        <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center gap-4">
            <a href="{{ route('store.products', $store->slug) }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10 shadow-lg transition-transform transform hover:scale-105">
                Belanja Sekarang
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('store.profile', $store->slug) }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10 backdrop-blur-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
