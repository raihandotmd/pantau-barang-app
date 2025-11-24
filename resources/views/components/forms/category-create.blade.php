<div class="p-6">
    <div class="mb-5">
        <div class="flex items-center">
            <div>
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
