@props(['name', 'show' => false])

<div
    x-data="{
        show: @js($show),
        item: null,
        formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        }
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="if ($event.detail.name == '{{ $name }}') { show = true; item = $event.detail.item; }"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex items-center justify-center"
    style="display: none;"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="p-6" x-show="item">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-lg font-bold text-gray-900">Detail Barang</h3>
                <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <!-- Item Image -->
            <div class="mb-6 flex justify-center">
                <template x-if="item.image">
                    <img :src="'/storage/' + item.image" :alt="item.name" class="h-48 w-full object-contain rounded-lg bg-gray-50">
                </template>
                <template x-if="!item.image">
                    <div class="h-48 w-full flex items-center justify-center bg-gray-100 rounded-lg text-gray-400">
                        <span class="text-sm">Tidak ada gambar</span>
                    </div>
                </template>
            </div>

            <!-- Item Details -->
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Nama Barang</p>
                    <p class="text-lg font-medium text-gray-900" x-text="item.name"></p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kode</p>
                        <p class="text-sm text-gray-900" x-text="item.code || '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kategori</p>
                        <p class="text-sm text-gray-900" x-text="item.category?.name || '-'"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Harga</p>
                        <p class="text-sm font-bold text-gray-900">Rp <span x-text="formatPrice(item.price)"></span></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Stok</p>
                        <p class="text-sm font-bold" :class="item.quantity <= 10 ? 'text-red-600' : 'text-green-600'" x-text="item.quantity"></p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Deskripsi</p>
                    <p class="text-sm text-gray-700 whitespace-pre-line" x-text="item.description || '-'"></p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                <button x-on:click="show = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
                <button x-on:click="show = false; setTimeout(() => $dispatch('open-modal', { name: 'edit-item', item: item }), 300)" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                    Edit Barang
                </button>
            </div>
        </div>
    </div>
</div>
