<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Form Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    <div class="mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Edit Item: {{ $item->name }}</h3>
                                <p class="text-gray-600">Update the item details and stock quantity</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('items.update', $item) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Item Name -->
                            <div>
                                <x-input-label for="name" :value="__('Item Name')" class="text-lg font-medium" />
                                <x-text-input id="name"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="text" name="name" :value="old('name', $item->name)" required autofocus
                                    placeholder="Enter item name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Item Code -->
                            <div>
                                <x-input-label for="code" :value="__('Item Code (Optional)')" class="text-lg font-medium" />
                                <x-text-input id="code"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="text" name="code" :value="old('code', $item->code)"
                                    placeholder="SKU, barcode, or custom code" />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Optional unique identifier for this item</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price (Rp)')" class="text-lg font-medium" />
                                <x-text-input id="price"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="number" step="0.01" min="0" name="price" :value="old('price', $item->price)" required
                                    placeholder="0.00" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Base Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Base Quantity')" class="text-lg font-medium" />
                                <x-text-input id="quantity"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="number" min="0" name="quantity" :value="old('quantity', $item->quantity)" required
                                    placeholder="0" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Current quantity: {{ $item->quantity }} units</p>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Category (Optional)')" class="text-lg font-medium" />
                            <select id="category_id" name="category_id" 
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                <option value="">-- No Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            @if($categories->isEmpty())
                                <p class="text-sm text-gray-500 mt-1">
                                    No categories available. 
                                    <a href="{{ route('categories.create') }}" class="text-blue-600 hover:text-blue-800 underline">Create a category first</a>
                                </p>
                            @else
                                <p class="text-sm text-gray-500 mt-1">Choose a category to organize this item</p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" class="text-lg font-medium" />
                            <textarea id="description"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none"
                                name="description" rows="4"
                                placeholder="Describe the item, its features, specifications, etc.">{{ old('description', $item->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Current Stock Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Current Stock Information</h4>
                            <div class="text-sm">
                                <span class="text-gray-500">Current Quantity:</span>
                                <span class="ml-2 font-semibold text-gray-900">{{ $item->quantity }} units</span>
                            </div>
                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="ml-2 text-sm text-blue-700">Changing the quantity will create a stock movement record to track the adjustment.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('items.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>