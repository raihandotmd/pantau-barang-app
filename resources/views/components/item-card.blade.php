@props(['item'])

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
                class="text-pantau-medium hover:text-pantau-dark text-sm font-medium">
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
