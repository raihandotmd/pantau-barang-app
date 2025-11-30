<x-front-layout>
    <x-front.navbar :store="$store" :transparent="false" />

    <div class="bg-gray-50 min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Semua Produk</h1>
                    <p class="mt-2 text-sm text-gray-500">Menampilkan {{ $items->total() }} produk tersedia</p>
                </div>
                
                <!-- Filters -->
                <div class="mt-4 md:mt-0">
                    <form method="GET" action="{{ route('store.products', $store->slug) }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-full sm:w-64 rounded-lg border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium shadow-sm">
                            <button type="submit" class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-pantau-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                        
                        <select name="category" onchange="this.form.submit()" class="rounded-lg border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('category'))
                <div class="flex items-center gap-2 mb-6">
                    <span class="text-sm text-gray-500">Filter aktif:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pantau-light/20 text-pantau-dark">
                            Pencarian: "{{ request('search') }}"
                            <a href="{{ route('store.products', ['slug' => $store->slug, 'category' => request('category')]) }}" class="ml-2 text-pantau-medium hover:text-pantau-dark">&times;</a>
                        </span>
                    @endif
                    @if(request('category'))
                        @php $catName = $categories->find(request('category'))->name ?? 'Unknown'; @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pantau-light/20 text-pantau-dark">
                            Kategori: {{ $catName }}
                            <a href="{{ route('store.products', ['slug' => $store->slug, 'search' => request('search')]) }}" class="ml-2 text-pantau-medium hover:text-pantau-dark">&times;</a>
                        </span>
                    @endif
                    <a href="{{ route('store.products', $store->slug) }}" class="text-sm text-gray-500 hover:text-pantau-medium underline">Reset Filter</a>
                </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse($items as $item)
                    <x-front.product-card :item="$item" />
                @empty
                    <div class="col-span-full text-center py-24">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                        <p class="mt-1 text-gray-500">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                        <a href="{{ route('store.products', $store->slug) }}" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pantau-medium hover:bg-pantau-dark">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $items->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <x-front.footer :store="$store" />
</x-front-layout>
