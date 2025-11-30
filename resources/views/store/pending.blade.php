<x-guest-layout>
    <x-slot name="hideLogo">true</x-slot>
    
    <div class="flex flex-col items-center justify-center text-center">
        <!-- Hourglass Icon -->
        <div class="mb-6 bg-yellow-50 p-4 rounded-full">
            <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            {{ __('Pengajuan Sedang Ditinjau') }}
        </h2>

        <div class="mb-8 text-gray-600 max-w-md mx-auto">
            {{ __('Terima kasih telah mendaftarkan toko Anda! Saat ini pengajuan toko Anda sedang dalam proses peninjauan oleh tim kami. Kami akan memberitahu Anda segera setelah toko Anda disetujui.') }}
        </div>

        <div class="w-full border-t border-gray-200 pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
