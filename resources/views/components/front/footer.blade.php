@props(['store'])

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
                    Platform multi-vendor terpercaya untuk inventaris dan pemesanan. Kelola toko Anda dengan mudah bersama kami.
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
