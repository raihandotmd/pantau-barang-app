@props(['items'])

<div class="p-6" x-data="stockMovementForm()">
    <div class="mb-5">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Catat Pergerakan Stok</h3>
            <p class="text-sm text-gray-500">Lacak perubahan inventaris (masuk/keluar)</p>
        </div>
    </div>

    <form method="POST" action="{{ route('stock-movements.store') }}" class="space-y-4">
        @csrf

        <!-- Item Selection (Searchable) -->
        <div class="relative">
            <x-input-label for="item_search" :value="__('Pilih Barang')" />
            
            <!-- Hidden Input for Form Submission -->
            <input type="hidden" name="item_id" x-model="selectedItemId" required>

            <!-- Search Input -->
            <div class="relative mt-1">
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @focus="openDropdown = true"
                    @click.away="openDropdown = false"
                    @keydown.escape="openDropdown = false"
                    placeholder="Cari nama barang..."
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3 pr-10"
                >
                <!-- Toggle Button (Chevron) -->
                <button 
                    type="button"
                    @click="openDropdown = !openDropdown"
                    class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                >
                    <svg class="h-5 w-5 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Dropdown List -->
            <div 
                x-show="openDropdown" 
                class="absolute z-50 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                style="display: none;"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
            >
                <template x-for="item in filteredItems" :key="item.id">
                    <div 
                        @click="selectItem(item)"
                        class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-blue-50 transition-colors duration-150"
                    >
                        <div class="flex justify-between items-center">
                            <span class="font-normal block truncate" x-text="item.name" :class="{'font-semibold': selectedItemId == item.id}"></span>
                            <span class="text-gray-500 text-xs bg-gray-100 px-2 py-1 rounded-full" x-text="'Stok: ' + item.quantity"></span>
                        </div>
                        <span x-show="selectedItemId == item.id" class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </template>
                
                <div x-show="filteredItems.length === 0" class="py-2 px-3 text-sm text-gray-500 text-center">
                    Tidak ada barang ditemukan.
                </div>
            </div>

            <x-input-error :messages="$errors->get('item_id')" class="mt-1" />

            <!-- Item Info Display -->
            <div x-show="selectedItemId" class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100" x-transition>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600">Stok Saat Ini</p>
                        <p class="text-lg font-bold text-blue-600" x-text="currentStock"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Harga Barang</p>
                        <p class="text-lg font-bold text-gray-900">Rp <span x-text="formatNumber(itemPrice)"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movement Type -->
        <div>
            <x-input-label :value="__('Jenis Pergerakan')" class="mb-2" />
            <div class="grid grid-cols-2 gap-3">
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none hover:bg-gray-50 transition-colors" :class="type === 'in' ? 'border-green-600 ring-1 ring-green-600 bg-green-50' : 'border-gray-300'">
                    <input type="radio" name="type" value="in" x-model="type" class="sr-only" required {{ old('type') === 'in' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-sm font-medium text-gray-900">
                                Stok Masuk
                            </span>
                            <span class="mt-0.5 text-xs text-gray-500">Tambah barang</span>
                        </span>
                    </span>
                    <span x-show="type === 'in'" class="absolute top-0 right-0 -mt-2 -mr-2 bg-green-600 text-white rounded-full p-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                </label>

                <label class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none hover:bg-gray-50 transition-colors" :class="type === 'out' ? 'border-red-600 ring-1 ring-red-600 bg-red-50' : 'border-gray-300'">
                    <input type="radio" name="type" value="out" x-model="type" class="sr-only" required {{ old('type') === 'out' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-sm font-medium text-gray-900">
                                Stok Keluar
                            </span>
                            <span class="mt-0.5 text-xs text-gray-500">Kurangi barang</span>
                        </span>
                    </span>
                    <span x-show="type === 'out'" class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-600 text-white rounded-full p-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('type')" class="mt-1" />
        </div>

        <!-- Quantity -->
        <div>
            <x-input-label for="quantity_change" :value="__('Jumlah')" />
            <input 
                type="number" 
                name="quantity_change" 
                id="quantity_change" 
                x-model="quantity"
                min="1"
                required
                value="{{ old('quantity_change') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3"
                placeholder="Masukkan jumlah"
            >
            <x-input-error :messages="$errors->get('quantity_change')" class="mt-1" />

            <!-- Stock Warning for Stock Out -->
            <div x-show="type === 'out' && quantity > currentStock" class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md" x-transition>
                <p class="text-xs text-red-600 flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Peringatan: Jumlah melebihi stok saat ini (<span x-text="currentStock"></span> tersedia)
                </p>
            </div>

            <!-- Projected Stock -->
            <div x-show="selectedItemId && quantity > 0" class="mt-2 p-2 bg-gray-50 rounded-md border border-gray-100" x-transition>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Estimasi Stok Akhir:</span>
                    <span class="font-bold" :class="type === 'in' ? 'text-green-600' : 'text-red-600'" x-text="getProjectedStock()"></span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div>
            <x-input-label for="notes" :value="__('Catatan / Alasan')" />
            <textarea 
                name="notes" 
                id="notes" 
                rows="2"
                maxlength="500"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3"
                placeholder="Contoh: Restock dari supplier, Terjual ke pelanggan, Barang rusak, dll."
            >{{ old('notes') }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Opsional: Berikan alasan untuk pergerakan stok ini</p>
            <x-input-error :messages="$errors->get('notes')" class="mt-1" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end pt-4 border-t border-gray-200 gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </button>

            <button 
                type="submit" 
                class="px-4 py-2 text-white font-medium rounded-md text-sm shadow-sm transition-colors"
                :class="type === 'out' && quantity > currentStock 
                    ? 'bg-gray-400 cursor-not-allowed opacity-75' 
                    : (type === 'in' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700')"
                :disabled="type === 'out' && quantity > currentStock"
            >
                <span x-show="type === 'in'">Catat Stok Masuk</span>
                <span x-show="type === 'out'">Catat Stok Keluar</span>
            </button>
        </div>
    </form>

    <script>
        function stockMovementForm() {
            return {
                items: @json($items),
                selectedItemId: '{{ old("item_id") }}',
                searchQuery: '',
                openDropdown: false,
                type: '{{ old("type", "in") }}',
                quantity: {{ old('quantity_change', 0) }},
                currentStock: 0,
                itemPrice: 0,

                get filteredItems() {
                    if (this.searchQuery === '') {
                        return this.items;
                    }
                    return this.items.filter(item => {
                        return item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    });
                },

                selectItem(item) {
                    this.selectedItemId = item.id;
                    this.searchQuery = item.name;
                    this.currentStock = item.quantity;
                    this.itemPrice = item.price;
                    this.openDropdown = false;
                },

                getProjectedStock() {
                    if (!this.selectedItemId || !this.quantity) return 0;
                    
                    if (this.type === 'in') {
                        return this.currentStock + parseInt(this.quantity);
                    } else {
                        return Math.max(0, this.currentStock - parseInt(this.quantity));
                    }
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                },

                init() {
                    if (this.selectedItemId) {
                        const item = this.items.find(i => i.id == this.selectedItemId);
                        if (item) {
                            this.selectItem(item);
                        }
                    }
                }
            }
        }
    </script>
</div>
