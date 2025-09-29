<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Category: ') . $category->name }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('categories.edit', $category) }}" 
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Category
                </a>
                <a href="{{ route('categories.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Category Overview Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h3>
                                <p class="text-gray-600 mt-1">Category Overview</p>
                            </div>
                        </div>

                        <!-- Category Stats -->
                        <div class="grid grid-cols-2 gap-6 text-center">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="text-3xl font-bold text-blue-600">{{ $category->items->count() }}</div>
                                <div class="text-sm text-blue-700">{{ Str::plural('Item', $category->items->count()) }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="text-3xl font-bold text-green-600">{{ $category->created_at->format('M Y') }}</div>
                                <div class="text-sm text-green-700">Created</div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Details -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Created Date</div>
                                    <div class="font-semibold text-gray-900">{{ $category->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Last Updated</div>
                                    <div class="font-semibold text-gray-900">{{ $category->updated_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Store</div>
                                    <div class="font-semibold text-gray-900">{{ $category->store->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items in Category -->
            @if ($category->items->count() > 0)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Items in this Category</h3>
                        <p class="text-gray-600">{{ $category->items->count() }} {{ Str::plural('item', $category->items->count()) }} {{ $category->items->count() === 1 ? 'is' : 'are' }} organized under this category</p>
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($category->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                            @if($item->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->current_stock }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->minimum_stock }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->current_stock <= $item->minimum_stock)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Low Stock
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    In Stock
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Items in This Category</h3>
                        <p class="text-gray-500 mb-6">This category doesn't have any items yet. Add items to organize your inventory.</p>
                        <a href="#" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Items
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>