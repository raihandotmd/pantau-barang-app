<x-front-layout>
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="font-bold text-2xl text-indigo-600 flex items-center gap-2">
                            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                PB
                            </div>
                            Pantau Barang
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-12 px-4 sm:px-6 lg:px-8 lg:py-24">
                <!-- Text Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block">Platform Manajemen</span>
                        <span class="block text-indigo-600">Stok & Toko Online</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Pantau Barang membantu Anda mengelola inventaris, memantau stok, dan menjual produk secara online dengan mudah. Temukan toko favorit Anda di bawah ini.
                    </p>
                    <div class="mt-5 sm:mt-8 flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-3">
                        <div class="rounded-md shadow">
                            <a href="#stores" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                Lihat Toko
                            </a>
                        </div>
                        @guest
                        <div>
                            <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                Buka Toko Gratis
                            </a>
                        </div>
                        @endguest
                    </div>
                </div>

                <!-- Image -->
                <div class="relative lg:h-full">
                    <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 object-cover" 
                         src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                         alt="Manajemen Toko">
                </div>
            </div>
        </div>
    </div>

    <!-- Stores List Section -->
    <div id="stores" class="bg-gray-50 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Daftar Toko</h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Jelajahi berbagai toko yang telah bergabung dengan Pantau Barang.
                </p>
            </div>

            <div class="mt-12 grid gap-8 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @forelse($stores as $store)
                    <div class="flex flex-col rounded-xl shadow-lg overflow-hidden bg-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex-shrink-0 relative h-48">
                            @if($store->banner_image)
                                <img class="h-full w-full object-cover" src="{{ Storage::url($store->banner_image) }}" alt="{{ $store->name }}">
                            @else
                                <div class="h-full w-full bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 m-4">
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm">
                                    {{ $store->status == 'active' ? 'Buka' : 'Menunggu' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <a href="{{ route('store.show', $store->slug) }}" class="block">
                                    <p class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition-colors">{{ $store->name }}</p>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ $store->description ?? 'Toko ini menyediakan berbagai macam barang berkualitas untuk kebutuhan Anda.' }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $store->address ?? 'Lokasi belum diatur' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('store.show', $store->slug) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                    Kunjungi Toko
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="mt-2 text-xl font-bold text-gray-900">Belum ada toko yang terdaftar</h3>
                        <p class="mt-2 text-base text-gray-500 max-w-sm mx-auto">Saat ini belum ada toko yang bergabung. Jadilah yang pertama membuka toko di platform kami!</p>
                        @guest
                        <div class="mt-8">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Daftarkan Toko Anda
                            </a>
                        </div>
                        @endguest
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                    <p class="text-center text-base text-gray-400">
                        pantau.barang@proton.me
                    </p>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400">
                        &copy; {{ date('Y') }} Pantau Barang. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
</x-front-layout>
