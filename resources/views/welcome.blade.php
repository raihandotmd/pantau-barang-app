<x-front-layout>
    <x-front.navbar :store="$store" />

    <!-- Hero Section -->
    <x-front.hero :store="$store" />

    <!-- Products Section -->
    <div id="products" class="bg-gray-50 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Katalog Produk</h2>
                    <p class="mt-2 text-gray-600">Koleksi produk yang tersedia di toko ini.</p>
                </div>
                <a href="{{ route('store.products', $store->slug) }}" class="hidden sm:flex items-center text-pantau-medium hover:text-pantau-dark font-medium">
                    Lihat Semua <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse($items as $item)
                    <x-front.product-card :item="$item" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                        <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center sm:hidden">
                <a href="{{ route('store.products', $store->slug) }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-pantau-medium hover:bg-pantau-dark w-full shadow-sm transition-colors">
                    Lihat Semua Produk <span aria-hidden="true" class="ml-2">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Promo Section -->
    <x-front.promo />

    <!-- Footer -->
    <x-front.footer :store="$store" />
</x-front-layout>
