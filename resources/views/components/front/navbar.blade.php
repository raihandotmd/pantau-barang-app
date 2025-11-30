@props(['store', 'transparent' => true])

<nav x-data="{ scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'bg-transparent': !scrolled && {{ $transparent ? 'true' : 'false' }} }"
    class="fixed w-full z-50 transition-all duration-300 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-3">
                <a href="{{ route('store.show', $store->slug) }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        PB
                    </div>
                    <span :class="{ 'text-gray-900': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="font-bold text-xl tracking-tight transition-colors">
                        Pantau Barang
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('store.show', $store->slug) }}" :class="{ 'text-gray-600 hover:text-indigo-600': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Beranda</a>
                <a href="{{ route('store.products', $store->slug) }}" :class="{ 'text-gray-600 hover:text-indigo-600': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Produk</a>
                <a href="{{ route('store.profile', $store->slug) }}" :class="{ 'text-gray-600 hover:text-indigo-600': scrolled || !{{ $transparent ? 'true' : 'false' }}, 'text-white/90 hover:text-white': !scrolled && {{ $transparent ? 'true' : 'false' }} }" class="text-sm font-medium transition-colors">Profil Toko</a>
                
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
</nav>
