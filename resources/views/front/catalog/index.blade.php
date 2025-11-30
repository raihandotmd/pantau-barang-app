<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header / Store Info -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">{{ $store->name }}</h1>
                <p class="text-gray-600 mt-2">{{ $store->description }}</p>
            </div>

            <!-- Search & Filter -->
            <div class="mb-8 bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('catalog.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search items..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-pantau-medium focus:ring-pantau-medium">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-pantau-medium focus:ring-pantau-medium">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-pantau-medium text-white rounded-md hover:bg-pantau-dark">Filter</button>
                </form>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($items as $item)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow">
                        <!-- Image Placeholder -->
                        <div class="h-48 bg-gray-200 w-full object-cover flex items-center justify-center text-gray-400">
                            @if($item->image_path)
                                <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                            @else
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <div class="text-xs text-gray-500 mb-1">{{ $item->category->name }}</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->name }}</h3>
                            <p class="text-pantau-medium font-bold mb-4">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            
                            <form action="{{ route('cart.add', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 transition-colors">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        No items found.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $items->links() }}
            </div>
        </div>
    </div>
    
    <!-- Floating Cart Button -->
    @if(session('cart') && count(session('cart')) > 0)
        <a href="{{ route('cart.index') }}" class="fixed bottom-8 right-8 bg-pantau-medium text-white p-4 rounded-full shadow-lg hover:bg-pantau-dark transition-colors z-50 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span class="font-bold">{{ count(session('cart')) }}</span>
        </a>
    @endif

</x-guest-layout>
