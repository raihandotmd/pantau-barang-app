@props(['item'])

<div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col h-full">
    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 group-hover:opacity-75 h-64 relative">
        @if($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
        @else
            <div class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
    </div>
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-pantau-dark bg-pantau-sand/50 px-2 py-1 rounded-md inline-block mb-2">
                        {{ $item->category->name ?? 'Sparepart' }}
                    </p>
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ $item->name }}
                    </h3>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $item->description ?? 'Kualitas terbaik untuk motor Anda.' }}</p>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <p class="text-lg font-bold text-pantau-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500">Stok: {{ $item->quantity }}</p>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2 relative z-10">
            <button @click="addToCart({{ $item->id }})" class="flex-1 bg-pantau-medium text-white py-2 px-4 rounded-lg font-medium hover:bg-pantau-dark transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Tambah
            </button>
            <button @click="buyNow({{ $item->id }})" class="flex-1 bg-pantau-light/20 text-pantau-dark py-2 px-4 rounded-lg font-medium hover:bg-pantau-light/40 transition-colors">
                Pesan & Ambil
            </button>
        </div>
    </div>
</div>
