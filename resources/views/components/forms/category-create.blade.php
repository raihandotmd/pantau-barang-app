<div class="p-6">
    <div class="mb-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h3>
                <p class="text-sm text-gray-500">Buat kategori untuk mengelompokkan barang Anda</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
        @csrf

        <!-- Category Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Kategori')" />
            <x-text-input id="name"
                class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                type="text" name="name" :value="old('name')" required autofocus
                placeholder="Masukkan nama kategori (contoh: Elektronik, Pakaian)" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
            <p class="text-xs text-gray-500 mt-1">Pilih nama yang deskriptif untuk memudahkan pengelompokan barang</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end pt-4 border-t border-gray-200 gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
