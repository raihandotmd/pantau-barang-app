<x-guest-layout>
    <x-slot name="hideLogo">true</x-slot>
    
    <div class="flex flex-col items-center justify-center text-center">
        <!-- Cross Icon -->
        <div class="mb-6 bg-red-50 p-4 rounded-full">
            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            {{ __('Pengajuan Ditolak') }}
        </h2>

        <div class="mb-8 text-gray-600 max-w-md mx-auto">
            {{ __('Maaf, pengajuan toko Anda ditolak. Silakan perbaiki data toko Anda dan ajukan ulang untuk ditinjau kembali.') }}
        </div>

        <div class="flex flex-col gap-3 w-full max-w-xs">
            <a href="{{ route('store-profile.edit') }}" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Perbaiki & Ajukan Ulang') }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
