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

        <!-- Item Selection -->
        <div>
            <x-input-label for="item_id" :value="__('Pilih Barang')" />
            <select 
                name="item_id" 
                id="item_id" 
                x-model="selectedItemId"
                @change="updateItemInfo()"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2 px-3"
            >
                <option value="">-- Pilih Barang --</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" 
                            data-name="{{ $item->name }}"
                            data-quantity="{{ $item->quantity }}"
                            data-price="{{ $item->price }}"
                            {{ old('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }} (Stok: {{ $item->quantity }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('item_id')" class="mt-1" />

            <!-- Item Info Display -->
            <div x-show="selectedItemId" class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
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
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none hover:bg-gray-50" :class="type === 'in' ? 'border-green-600 ring-1 ring-green-600 bg-green-50' : 'border-gray-300'">
                    <input type="radio" name="type" value="in" x-model="type" class="sr-only" required {{ old('type') === 'in' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-sm font-medium text-gray-900">
                                Stok Masuk
                            </span>
                            <span class="mt-0.5 text-xs text-gray-500">Tambah barang</span>
                        </span>
                    </span>
                </label>

                <label class="relative flex cursor-pointer rounded-lg border bg-white p-3 shadow-sm focus:outline-none hover:bg-gray-50" :class="type === 'out' ? 'border-red-600 ring-1 ring-red-600 bg-red-50' : 'border-gray-300'">
                    <input type="radio" name="type" value="out" x-model="type" class="sr-only" required {{ old('type') === 'out' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-sm font-medium text-gray-900">
                                Stok Keluar
                            </span>
                            <span class="mt-0.5 text-xs text-gray-500">Kurangi barang</span>
                        </span>
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
            <div x-show="type === 'out' && quantity > currentStock" class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                <p class="text-xs text-red-600 flex items-center">
                    Peringatan: Jumlah melebihi stok saat ini (<span x-text="currentStock"></span> tersedia)
                </p>
            </div>

            <!-- Projected Stock -->
            <div x-show="selectedItemId && quantity > 0" class="mt-2 p-2 bg-gray-50 rounded-md border border-gray-100">
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
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
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
                selectedItemId: '{{ old("item_id") }}',
                type: '{{ old("type", "in") }}',
                quantity: {{ old('quantity_change', 0) }},
                currentStock: 0,
                itemPrice: 0,
                itemName: '',

                updateItemInfo() {
                    const select = document.getElementById('item_id');
                    const option = select.options[select.selectedIndex];
                    
                    if (option.value) {
                        this.currentStock = parseInt(option.getAttribute('data-quantity')) || 0;
                        this.itemPrice = parseFloat(option.getAttribute('data-price')) || 0;
                        this.itemName = option.getAttribute('data-name') || '';
                    } else {
                        this.currentStock = 0;
                        this.itemPrice = 0;
                        this.itemName = '';
                    }
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
                        this.updateItemInfo();
                    }
                }
            }
        }
    </script>
</div>
