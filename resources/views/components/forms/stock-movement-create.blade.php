@props(['items'])

<div class="p-6" x-data="stockMovementForm()">
    <div class="mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Record Stock Movement</h3>
                <p class="text-gray-600">Track inventory changes (in/out)</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('stock-movements.store') }}">
        @csrf

        <!-- Item Selection -->
        <div class="mb-6">
            <x-input-label for="item_id" :value="__('Select Item')" class="text-sm font-medium text-gray-700 mb-2" />
            <select 
                name="item_id" 
                id="item_id" 
                x-model="selectedItemId"
                @change="updateItemInfo()"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg py-3 px-4"
            >
                <option value="">-- Select an Item --</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" 
                            data-name="{{ $item->name }}"
                            data-quantity="{{ $item->quantity }}"
                            data-price="{{ $item->price }}"
                            {{ old('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }} (Stock: {{ $item->quantity }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('item_id')" class="mt-2" />

            <!-- Item Info Display -->
            <div x-show="selectedItemId" class="mt-4 p-4 bg-blue-50 rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Current Stock</p>
                        <p class="text-2xl font-bold text-blue-600" x-text="currentStock"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Item Price</p>
                        <p class="text-2xl font-bold text-gray-900">Rp <span x-text="formatNumber(itemPrice)"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movement Type -->
        <div class="mb-6">
            <x-input-label :value="__('Movement Type')" class="block text-sm font-medium text-gray-700 mb-2" />
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none" :class="type === 'in' ? 'border-green-600 ring-2 ring-green-600' : 'border-gray-300'">
                    <input type="radio" name="type" value="in" x-model="type" class="sr-only" required {{ old('type') === 'in' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-lg font-medium text-gray-900">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4"></path>
                                </svg>
                                Stock In
                            </span>
                            <span class="mt-1 text-sm text-gray-500">Add items</span>
                        </span>
                    </span>
                </label>

                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none" :class="type === 'out' ? 'border-red-600 ring-2 ring-red-600' : 'border-gray-300'">
                    <input type="radio" name="type" value="out" x-model="type" class="sr-only" required {{ old('type') === 'out' ? 'checked' : '' }}>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span class="flex items-center text-lg font-medium text-gray-900">
                                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m0 0l4 4m-4-4l-4 4"></path>
                                </svg>
                                Stock Out
                            </span>
                            <span class="mt-1 text-sm text-gray-500">Remove items</span>
                        </span>
                    </span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        <!-- Quantity -->
        <div class="mb-6">
            <x-input-label for="quantity_change" :value="__('Quantity')" class="block text-sm font-medium text-gray-700 mb-2" />
            <input 
                type="number" 
                name="quantity_change" 
                id="quantity_change" 
                x-model="quantity"
                min="1"
                required
                value="{{ old('quantity_change') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg py-3 px-4"
                placeholder="Enter quantity"
            >
            <x-input-error :messages="$errors->get('quantity_change')" class="mt-2" />

            <!-- Stock Warning for Stock Out -->
            <div x-show="type === 'out' && quantity > currentStock" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Warning: Quantity exceeds current stock (<span x-text="currentStock" class="mr-1"></span> available)
                </p>
            </div>

            <!-- Projected Stock -->
            <div x-show="selectedItemId && quantity > 0" class="mt-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Projected Stock After Movement:</span>
                    <span class="text-lg font-bold" :class="type === 'in' ? 'text-green-600' : 'text-red-600'" x-text="getProjectedStock()"></span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <x-input-label for="notes" :value="__('Notes / Reason')" class="block text-sm font-medium text-gray-700 mb-2" />
            <textarea 
                name="notes" 
                id="notes" 
                rows="3"
                maxlength="500"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="e.g., Restocking from supplier, Sold to customer, Damaged goods, etc."
            >{{ old('notes') }}</textarea>
            <p class="mt-1 text-sm text-gray-500">Optional: Provide a reason for this stock movement</p>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <button type="button" x-on:click="$dispatch('close')"
                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Cancel
            </button>

            <button 
                type="submit" 
                class="inline-flex items-center px-8 py-3 text-white font-semibold rounded-xl transition-all duration-200 transform shadow-lg"
                :class="type === 'out' && quantity > currentStock 
                    ? 'bg-gray-400 cursor-not-allowed opacity-75' 
                    : (type === 'in' ? 'bg-green-600 hover:bg-green-700 hover:scale-105' : 'bg-red-600 hover:bg-red-700 hover:scale-105')"
                :disabled="type === 'out' && quantity > currentStock"
            >
                <span x-show="type === 'in'">Record Stock In</span>
                <span x-show="type === 'out'">Record Stock Out</span>
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
