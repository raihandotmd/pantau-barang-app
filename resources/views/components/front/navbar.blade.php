@props(['store', 'transparent' => true])

<nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'bg-transparent': !scrolled && {{ $transparent ? 'true' : 'false' }} }"
    class="fixed w-full z-50 transition-all duration-300 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-3">
                <a href="{{ route('store.show', $store->slug) }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pantau-medium rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        PB
                    </div>
                    <span :class="{ 'text-gray-900': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="font-bold text-xl tracking-tight transition-colors">
                        Pantau Barang
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('store.show', $store->slug) }}" :class="{ 'text-gray-600 hover:text-pantau-medium': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Beranda</a>
                <a href="{{ route('store.products', $store->slug) }}" :class="{ 'text-gray-600 hover:text-pantau-medium': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Produk</a>
                <a href="{{ route('store.profile', $store->slug) }}" :class="{ 'text-gray-600 hover:text-pantau-medium': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Profil Toko</a>
                
                <!-- Cart Button -->
                <button @click="$dispatch('open-cart')" 
                    :class="{ 'text-gray-900 bg-gray-100 hover:bg-gray-200': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white bg-white/20 hover:bg-white/30': !scrolled && {{ $transparent ? 'true' : 'false' }} }"
                    class="relative p-2 rounded-full transition-all duration-300 group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="cartCount > 0" 
                        x-transition.scale
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-md"
                        x-text="cartCount">
                    </span>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    :class="{ 'text-gray-900': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }"
                    class="p-2 rounded-md focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white shadow-lg absolute w-full top-20 left-0 border-t border-gray-100"
        @click.away="mobileMenuOpen = false">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('store.show', $store->slug) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-pantau-medium hover:bg-gray-50">Beranda</a>
            <a href="{{ route('store.products', $store->slug) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-pantau-medium hover:bg-gray-50">Produk</a>
            <a href="{{ route('store.profile', $store->slug) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-pantau-medium hover:bg-gray-50">Profil Toko</a>
            
            <div class="border-t border-gray-100 my-2 pt-2">
                <button @click="$dispatch('open-cart'); mobileMenuOpen = false" class="flex w-full items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-pantau-medium hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Keranjang
                    <span x-show="cartCount > 0" class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full" x-text="cartCount"></span>
                </button>
            </div>
        </div>
    </div>
</nav>
