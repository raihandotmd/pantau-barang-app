<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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
                                <h3 class="text-lg font-semibold text-gray-900">Edit Category</h3>
                                <p class="text-gray-600">Update the category information</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Category Name -->
                        <div>
                            <x-input-label for="name" :value="__('Category Name')" class="text-lg font-medium" />
                            <x-text-input id="name"
                                class="block mt-2 w-full text-lg py-3 px-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                                type="text" name="name" :value="old('name', $category->name)" required autofocus
                                placeholder="Enter category name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Choose a descriptive name that will help organize your items</p>
                        </div>

                        <!-- Category Stats -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Category Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Items in this category:</span>
                                    <span class="ml-2 font-semibold text-gray-900">{{ $category->items->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Created:</span>
                                    <span class="ml-2 font-semibold text-gray-900">{{ $category->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @if($category->items->count() > 0)
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="ml-2 text-sm text-blue-700">This category contains {{ $category->items->count() }} {{ Str::plural('item', $category->items->count()) }}. Updating the category name won't affect the items.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('categories.index') }}"
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
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>