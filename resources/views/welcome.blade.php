<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pantau Barang') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50"
        x-data="{
            cart: {{ json_encode(session('cart', [])) }},
            cartCount: {{ count(session('cart', [])) }},
            cartTotal: {{ array_reduce(session('cart', []), function($carry, $item) { return $carry + ($item['price'] * $item['quantity']); }, 0) }},
            mobileMenuOpen: false,
            
            addToCart(itemId) {
                fetch(`/cart/add/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        this.cart = data.cart;
                        this.cartCount = data.cart_count;
                        this.updateTotal();
                        $dispatch('open-cart');
                    }
                });
            },
            
            removeFromCart(itemId) {
                fetch(`/cart/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id: itemId })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        this.cart = data.cart;
                        this.cartCount = data.cart_count;
                        this.updateTotal();
                    }
                });
            },

            updateTotal() {
                this.cartTotal = Object.values(this.cart).reduce((acc, item) => acc + (item.price * item.quantity), 0);
            },

            buyNow(itemId) {
                this.addToCart(itemId);
                setTimeout(() => {
                    $dispatch('open-checkout');
                }, 500);
            }
        }">

        <x-front.navbar :store="$store" />

        <!-- Hero Section -->
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
                    <a href="#products" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10 shadow-lg transition-transform transform hover:scale-105">
                        Belanja Sekarang
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#contact" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10 backdrop-blur-sm">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div id="products" class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Produk Terpopuler</h2>
                        <p class="mt-2 text-gray-600">Pilihan terbaik untuk motor kesayangan Anda.</p>
                    </div>
                    <a href="#" class="hidden sm:flex items-center text-indigo-600 hover:text-indigo-500 font-medium">
                        Lihat Semua <span aria-hidden="true"> &rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @forelse($items as $item)
                        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col h-full">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 group-hover:opacity-75 h-64 relative">
                                @if($item->image_path)
                                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                <!-- Quick Actions Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
                                    <button @click="buyNow({{ $item->id }})" class="bg-white text-gray-900 px-4 py-2 rounded-full font-medium shadow-lg hover:bg-indigo-50 transform hover:scale-105 transition-all">
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md inline-block mb-2">
                                                {{ $item->category->name ?? 'Sparepart' }}
                                            </p>
                                            <h3 class="text-lg font-bold text-gray-900">
                                                <a href="#">
                                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                                    {{ $item->name }}
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $item->description ?? 'Kualitas terbaik untuk motor Anda.' }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500">Stok: {{ $item->quantity }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2 relative z-10">
                                    <button @click="addToCart({{ $item->id }})" class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Tambah
                                    </button>
                                    <button @click="buyNow({{ $item->id }})" class="flex-1 bg-indigo-50 text-indigo-700 py-2 px-4 rounded-lg font-medium hover:bg-indigo-100 transition-colors">
                                        Pesan & Ambil
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                            <p class="mt-1 text-sm text-gray-500">Silakan cek kembali nanti.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-12 text-center sm:hidden">
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-500">Lihat Semua Produk &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Promo Section -->
        <div class="bg-gray-900">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 lg:py-24 lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-1/2">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-800 text-indigo-100 mb-4">
                        Platform Multi-Vendor
                    </span>
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        <span class="block">Buka Toko Online &</span>
                        <span class="block text-indigo-400">Jual Spareparts Motor Anda</span>
                    </h2>
                    <p class="mt-4 text-lg text-gray-400">
                        Bergabunglah dengan platform Pantau Barang dan mulai menjual produk spareparts motor Anda secara online. Jangkau lebih banyak pelanggan di Jakarta Timur dan sekitarnya.
                    </p>
                    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="ml-3 text-gray-300">Gratis buka toko dan kelola produk</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="ml-3 text-gray-300">Dashboard penjual yang mudah digunakan</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="ml-3 text-gray-300">Jangkauan pelanggan lebih luas</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="ml-3 text-gray-300">Dukungan sistem pembayaran dan pengiriman</span>
                        </div>
                    </div>
                    <div class="mt-10">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Daftar Sebagai Penjual
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0 lg:w-1/2 lg:pl-10">
                    <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
                        <div class="p-6 sm:p-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="bg-indigo-900 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Kelola Produk</h3>
                                    <p class="text-gray-400 text-sm">Tambah, edit, dan kelola stok produk dengan mudah</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="bg-indigo-900 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">Terima Pesanan</h3>
                                    <p class="text-gray-400 text-sm">Monitor dan proses pesanan real-time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer id="contact" class="bg-indigo-900 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Brand & Platform Info -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-indigo-900 font-bold text-xl">PB</div>
                            <span class="font-bold text-2xl tracking-tight">Pantau Barang</span>
                        </div>
                        <p class="text-indigo-200 text-sm leading-relaxed max-w-xs">
                            Platform multi-vendor terpercaya untuk inventaris dan pemesanan spareparts motor. Kelola toko Anda dengan mudah bersama kami.
                        </p>
                        <div class="pt-2">
                            <a href="mailto:pantau.barang@proton.me" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                pantau.barang@proton.me
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links (Platform) -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6">Tautan</h4>
                        <ul class="space-y-4">
                            @auth
                                <li>
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        Dashboard Toko
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        Masuk Toko
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        Buka Toko Baru
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>

                    <!-- Store Info (Dynamic) -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6">Informasi Toko</h3>
                        <div class="space-y-4 text-indigo-200 text-sm">
                            <div>
                                <h4 class="font-semibold text-white mb-1">{{ $store->name ?? 'Pantau Barang' }}</h4>
                                <p>{{ $store->address ?? 'Alamat belum diatur' }}</p>
                                <p>{{ $store->city ?? '' }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white mb-1">Kontak</h4>
                                <p>{{ $store->contact_info }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 pt-8 border-t border-indigo-800 text-center text-sm text-indigo-400">
                    <p>&copy; {{ date('Y') }} Pantau Barang. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Components -->
        <x-front.cart-drawer />
        <x-front.checkout-modal />

    </body>
</html>
