<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Image -->
                        <div class="h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                            @if($item->image_path)
                                <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->name }}" class="h-full w-full object-cover rounded-lg">
                            @else
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>

                        <!-- Details -->
                        <div>
                            <div class="text-sm text-gray-500 mb-2">{{ $item->category->name }}</div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $item->name }}</h1>
                            <p class="text-2xl font-bold text-pantau-medium mb-6">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            
                            <div class="prose max-w-none mb-8 text-gray-600">
                                {{ $item->description }}
                            </div>

                            <div class="border-t pt-6">
                                <form action="{{ route('cart.add', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto bg-pantau-medium text-white py-3 px-8 rounded-md hover:bg-pantau-dark font-bold shadow-lg transition-transform transform hover:scale-105">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
