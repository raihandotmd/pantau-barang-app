<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Item') }}
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
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Add New Item to Inventory</h3>
                                <p class="text-gray-600">Fill in the details to add a new item to your store</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('items.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Item Name -->
                            <div>
                                <x-input-label for="name" :value="__('Item Name')" class="text-lg font-medium" />
                                <x-text-input id="name"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="text" name="name" :value="old('name')" required autofocus
                                    placeholder="Enter item name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Item Code -->
                            <div>
                                <x-input-label for="code" :value="__('Item Code (Optional)')" class="text-lg font-medium" />
                                <x-text-input id="code"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="text" name="code" :value="old('code')"
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
                                    type="number" step="0.01" min="0" name="price" :value="old('price')" required
                                    placeholder="0.00" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Initial Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Initial Quantity')" class="text-lg font-medium" />
                                <x-text-input id="quantity"
                                    class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                    type="number" min="0" name="quantity" :value="old('quantity')" required
                                    placeholder="0" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Starting stock quantity for this item</p>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Category (Optional)')" class="text-lg font-medium" />
                            <select id="category_id" name="category_id" 
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                <option value="">-- No Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            @if($categories->isEmpty())
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
                                placeholder="Describe the item, its features, specifications, etc.">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Tips for Adding Items</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Use descriptive names that help identify the item quickly</li>
                                <li>Item codes can be SKUs, barcodes, or any custom identifier</li>
                                <li>Set the initial quantity - you can adjust stock levels later</li>
                                <li>Categories help organize items for better inventory management</li>
                                <li>All stock changes will be tracked in movement history</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>