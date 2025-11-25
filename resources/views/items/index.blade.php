<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Items & Inventory') }}
            </h2>
            <a href="{{ route('items.create') }}">
                <x-primary-button>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Item
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('items.index') }}" class="flex flex-wrap gap-4">
                        <!-- Search -->
                        <div class="flex-1 min-w-64">
                            <x-text-input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search items..." 
                                class="w-full" />
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="min-w-48">
                            <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <x-primary-button>
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                            Filter
                        </x-primary-button>

                        <!-- Clear Filter -->
                        @if(request('search') || request('category'))
                            <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Items Grid -->
            @if ($items->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($items as $item)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate" title="{{ $item->name }}">{{ $item->name }}</h3>
                                    <!-- Stock Status Badge -->
                                    @if($item->isLowStock())
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            In Stock
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Item Details -->
                                <div class="space-y-2 mb-4">
                                    @if($item->code)
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Code:</span> {{ $item->code }}
                                        </p>
                                    @endif
                                    
                                    @if($item->category)
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Category:</span> {{ $item->category->name }}
                                        </p>
                                    @endif
                                    
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Price:</span> Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Stock:</span> {{ $item->quantity }} units
                                    </p>
                                    
                                    @if($item->description)
                                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $item->description }}</p>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                    <!-- View Button -->
                                    <a href="{{ route('items.show', $item) }}" 
                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        View Details
                                    </a>
                                    
                                    <div class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('items.edit', $item) }}" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('items.destroy', $item) }}" class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this item? Stock movement history will be preserved.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            @if(request('search') || request('category'))
                                No Items Found
                            @else
                                No Items Yet
                            @endif
                        </h3>
                        <p class="text-gray-500 mb-6">
                            @if(request('search') || request('category'))
                                Try adjusting your search or filter criteria.
                            @else
                                Add your first item to start managing your inventory.
                            @endif
                        </p>
                        
                        @if(!request('search') && !request('category'))
                            <a href="{{ route('items.create') }}">
                                <x-primary-button>
                                    Add First Item
                                </x-primary-button>
                            </a>
                        @else
                            <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>