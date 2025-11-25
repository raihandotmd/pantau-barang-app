<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pantau Barang') }} - Profil Toko</title>

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
            }
        }">

        <x-front.navbar :store="$store" />

        <div class="pt-32 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Banner Image -->
                <div class="relative h-64 w-full bg-gray-200">
                    @if($store->banner_image)
                        <img src="{{ Storage::url($store->banner_image) }}" alt="Store Banner" class="h-full w-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Default Banner" class="h-full w-full object-cover">
                    @endif
                    
                </div>

                <div class="pt-8 pb-8 px-8 sm:px-12">
                    <div class="flex flex-col gap-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ strtoupper($store->name) }}</h1>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                            <!-- Left Column: Description & Contact -->
                            <div class="lg:col-span-1 space-y-8">
                                <div class="prose prose-indigo text-gray-600 max-w-none">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tentang Toko</h3>
                                    <p>{{ $store->description ?? 'Deskripsi toko belum tersedia.' }}</p>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        Kontak Kami
                                    </h3>
                                    <ul class="space-y-4 text-gray-600">
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-6 pt-1">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-medium text-gray-900">Alamat</span>
                                                <span class="block text-sm">{{ $store->address }}</span>
                                            </div>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-6 pt-1">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-medium text-gray-900">Kontak</span>
                                                <span class="block text-sm">{{ $store->contact_info ?? '-' }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Right Column: Map -->
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    Lokasi Toko
                                </h3>
                                <div id="store-profile-map" class="h-[500px] w-full rounded-xl border border-gray-200 shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer id="contact" class="bg-indigo-900 text-white mt-12">
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
                        <h3 class="text-lg font-bold text-white mb-6">Akses Pengguna</h3>
                        <ul class="space-y-4">
                            @auth
                                <li>
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        Dashboard Toko
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                        Masuk Toko
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-indigo-200 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
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
                                <h4 class="font-semibold text-white mb-1">Jam Operasional</h4>
                                <p>Senin - Minggu: 09:00 - 20:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 pt-8 border-t border-indigo-800 text-center text-sm text-indigo-400">
                    <p>&copy; {{ date('Y') }} Pantau Barang. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <x-front.cart-drawer />
        <x-front.checkout-modal />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $store->location ? $store->location->getLatitude() : -6.200000 }};
                const lng = {{ $store->location ? $store->location->getLongitude() : 106.816666 }};
                
                const map = L.map('store-profile-map').setView([lat, lng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup('{{ $store->name }}')
                    .openPopup();
            });
        </script>
    </body>
</html>
