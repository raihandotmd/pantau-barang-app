@props(['categories'])

<div x-data="{
    item: null,
    action: '',
    init() {
        this.$watch('item', value => {
            if (value) {
                this.action = '/items/' + value.id;
            }
        });
    }
}"
x-on:open-modal.window="if ($event.detail.name === 'edit-item') { item = $event.detail.item; }"
>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Barang</h2>
        <form x-bind:action="action" method="POST" class="space-y-6" x-show="item">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Item Name -->
            <div>
                <x-input-label for="edit_name" :value="__('Nama Barang')" />
                <x-text-input id="edit_name" class="block mt-1 w-full" type="text" name="name" x-model="item.name" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Item Code -->
            <div>
                <x-input-label for="edit_code" :value="__('Kode Barang (Opsional)')" />
                <x-text-input id="edit_code" class="block mt-1 w-full" type="text" name="code" x-model="item.code" />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Price -->
            <div>
                <x-input-label for="edit_price" :value="__('Harga (Rp)')" />
                <x-text-input id="edit_price" class="block mt-1 w-full" type="number" step="0.01" min="0" name="price" x-model="item.price" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <!-- Quantity -->
            <div>
                <x-input-label for="edit_quantity" :value="__('Stok Awal')" />
                <x-text-input id="edit_quantity" class="block mt-1 w-full" type="number" min="0" name="quantity" x-model="item.quantity" required />
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">Mengubah stok di sini akan membuat catatan pergerakan stok otomatis.</p>
            </div>
        </div>

        <!-- Category -->
        <div>
            <x-input-label for="edit_category_id" :value="__('Kategori')" />
            <select id="edit_category_id" name="category_id" x-model="item.category_id"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Tanpa Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="edit_description" :value="__('Deskripsi (Opsional)')" />
            <textarea id="edit_description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" rows="3" x-model="item.description"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6 gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
    </div>
</div>
