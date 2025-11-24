@props(['categories'])

<div class="p-6">
    <div class="mb-5">
        <div class="flex items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Tambah Barang Baru</h3>
                <p class="text-sm text-gray-500">Isi detail untuk menambahkan barang ke toko Anda</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('items.store') }}" class="space-y-4" enctype="multipart/form-data">
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

        <!-- Image -->
        <div>
            <x-input-label for="image" :value="__('Gambar Barang (Opsional)')" />
            <input id="image" type="file" name="image" accept="image/*"
                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            <x-input-error :messages="$errors->get('image')" class="mt-1" />
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB.</p>
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
