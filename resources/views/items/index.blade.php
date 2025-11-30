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
                            <select name="category" class="border-gray-300 focus:border-pantau-medium focus:ring-pantau-medium rounded-md shadow-sm w-full">
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
                            <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Items Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($items as $item)
                    <x-item-card :item="$item" />
                @empty
                    <div class="col-span-full">
                        <x-empty-state 
                            title="{{ (request('search') || request('category')) ? 'No Items Found' : 'No Items Yet' }}"
                            description="{{ (request('search') || request('category')) ? 'Try adjusting your search or filter criteria.' : 'Add your first item to start managing your inventory.' }}"
                        >
                            @if(!request('search') && !request('category'))
                                <a href="{{ route('items.create') }}">
                                    <x-primary-button>
                                        Add First Item
                                    </x-primary-button>
                                </a>
                            @else
                                <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pantau-medium focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Clear Filters
                                </a>
                            @endif
                        </x-empty-state>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($items->hasPages())
                <div class="mt-6">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>