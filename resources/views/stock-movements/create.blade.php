<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Record Stock Movement') }}
            </h2>
            <a href="{{ route('stock-movements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('stock-movements.store') }}" x-data="stockMovementForm()">
                        @csrf

                        <!-- Item Selection -->
                        <div class="mb-6">
                            <label for="item_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Item <span class="text-red-500">*</span>
                            </label>
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
                            @error('item_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

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
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Movement Type <span class="text-red-500">*</span>
                            </label>
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
                                            <span class="mt-1 text-sm text-gray-500">Add items to inventory</span>
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
                                            <span class="mt-1 text-sm text-gray-500">Remove items from inventory</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity_change" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
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
                            @error('quantity_change')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Stock Warning for Stock Out -->
                            <div x-show="type === 'out' && quantity > currentStock" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm text-red-600 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Warning: Quantity exceeds current stock (<span x-text="currentStock"></span> available)
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
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notes / Reason
                            </label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="4"
                                maxlength="500"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g., Restocking from supplier, Sold to customer, Damaged goods, etc."
                            >{{ old('notes') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Optional: Provide a reason for this stock movement (max 500 characters)</p>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4 mt-8">
                            <a href="{{ route('stock-movements.index') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                Cancel
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-3 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg"
                                :class="type === 'in' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
                            >
                                <span x-show="type === 'in'">Record Stock In</span>
                                <span x-show="type === 'out'">Record Stock Out</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
</x-app-layout>
