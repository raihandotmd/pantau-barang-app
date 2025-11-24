@props(['categories'])

<div class="p-6">
    <div class="mb-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Barang Baru</h3>
                <p class="text-sm text-gray-500">Isi detail untuk menambahkan barang ke toko Anda</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('items.store') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Item Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Barang')" />
                <x-text-input id="name"
                    class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                    type="text" name="name" :value="old('name')" required autofocus
                    placeholder="Masukkan nama barang" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Item Code -->
            <div>
                <x-input-label for="code" :value="__('Kode Barang (Opsional)')" />
                <x-text-input id="code"
                    class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                    type="text" name="code" :value="old('code')"
                    placeholder="SKU, barcode, atau kode kustom" />
                <x-input-error :messages="$errors->get('code')" class="mt-1" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Price -->
            <div>
                <x-input-label for="price" :value="__('Harga (Rp)')" />
                <x-text-input id="price"
                    class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                    type="number" step="0.01" min="0" name="price" :value="old('price')" required
                    placeholder="0.00" />
                <x-input-error :messages="$errors->get('price')" class="mt-1" />
            </div>

            <!-- Initial Quantity -->
            <div>
                <x-input-label for="quantity" :value="__('Stok Awal')" />
                <x-text-input id="quantity"
                    class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                    type="number" min="0" name="quantity" :value="old('quantity')" required
                    placeholder="0" />
                <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
            </div>
        </div>

        <!-- Category -->
        <div>
            <x-input-label for="category_id" :value="__('Kategori (Opsional)')" />
            <select id="category_id" name="category_id" 
                class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                <option value="">-- Tanpa Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
            @if($categories->isEmpty())
                <p class="text-xs text-red-500 mt-1">
                    Belum ada kategori. 
                    <button type="button" x-on:click="$dispatch('close'); setTimeout(() => $dispatch('open-modal', 'create-category'), 300)" class="text-blue-600 hover:text-blue-800 underline">Buat kategori dulu</button>
                </p>
            @endif
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
            <textarea id="description"
                class="block mt-1 w-full text-sm py-2 px-3 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 resize-none"
                name="description" rows="3"
                placeholder="Deskripsikan barang...">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-1" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end pt-4 border-t border-gray-200 gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                Simpan Barang
            </button>
        </div>
    </form>
</div>
