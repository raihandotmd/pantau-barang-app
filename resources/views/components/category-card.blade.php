@props(['category'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h3>
            <div class="flex items-center space-x-2">
                <!-- View Button -->
                <a href="{{ route('categories.show', $category) }}" 
                    class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    View
                </a>
                <!-- Edit Button -->
                <a href="{{ route('categories.edit', $category) }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <!-- Delete Button -->
                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline-block"
                    onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="text-red-400 hover:text-red-600"
                        @if($category->items->count() > 0) disabled title="Cannot delete category with items" @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Category Stats -->
        <div class="flex items-center justify-between text-sm text-gray-600 mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                {{ $category->items->count() }} {{ Str::plural('item', $category->items->count()) }}
            </div>
            <div class="text-xs text-gray-500">
                Created {{ $category->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
