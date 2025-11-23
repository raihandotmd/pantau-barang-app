<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Add New Category</h3>
                <p class="text-gray-600">Create a category to organize your inventory items</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
        @csrf

        <!-- Category Name -->
        <div>
            <x-input-label for="name" :value="__('Category Name')" class="text-lg font-medium" />
            <x-text-input id="name"
                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                type="text" name="name" :value="old('name')" required autofocus
                placeholder="Enter category name (e.g., Electronics, Clothing, Books)" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <p class="text-sm text-gray-500 mt-1">Choose a descriptive name that will help organize your items</p>
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

            <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Category
            </button>
        </div>
    </form>
</div>
