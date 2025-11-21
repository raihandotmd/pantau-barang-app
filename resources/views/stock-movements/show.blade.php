<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Stock Movement Details') }}
            </h2>
            <a href="{{ route('stock-movements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Movement Type Badge -->
                    <div class="mb-6">
                        @if($stockMovement->type === 'in')
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-lg font-semibold bg-green-100 text-green-800">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4"></path>
                                </svg>
                                Stock In Movement
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-lg font-semibold bg-red-100 text-red-800">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m0 0l4 4m-4-4l-4 4"></path>
                                </svg>
                                Stock Out Movement
                            </span>
                        @endif
                    </div>

                    <!-- Movement Details -->
                    <div class="space-y-6">
                        <!-- Item Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Item Name</label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $stockMovement->item->name ?? 'Deleted Item' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Item Code</label>
                                    <p class="text-lg text-gray-900">
                                        {{ $stockMovement->item->code ?? 'N/A' }}
                                    </p>
                                </div>
                                @if($stockMovement->item)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Category</label>
                                        <p class="text-lg text-gray-900">
                                            {{ $stockMovement->item->category->name ?? 'No Category' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Current Stock</label>
                                        <p class="text-lg font-bold text-blue-600">
                                            {{ $stockMovement->item->quantity }} units
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Movement Details -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Movement Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Quantity Changed</label>
                                    <p class="text-3xl font-bold {{ $stockMovement->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $stockMovement->type === 'in' ? '+' : '-' }}{{ $stockMovement->quantity_change }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Date & Time</label>
                                    <p class="text-lg text-gray-900">
                                        {{ $stockMovement->created_at->format('d F Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $stockMovement->created_at->format('H:i:s') }} ({{ $stockMovement->created_at->diffForHumans() }})
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Recorded By</label>
                                    <p class="text-lg text-gray-900">
                                        {{ $stockMovement->user->name ?? 'Unknown User' }}
                                    </p>
                                    @if($stockMovement->user)
                                        <p class="text-sm text-gray-500">
                                            {{ $stockMovement->user->email }}
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Movement ID</label>
                                    <p class="text-lg text-gray-900 font-mono">
                                        #{{ str_pad($stockMovement->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes / Reason</h3>
                            @if($stockMovement->notes)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $stockMovement->notes }}</p>
                                </div>
                            @else
                                <p class="text-gray-500 italic">No notes provided for this movement.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('stock-movements.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to List
                        </a>

                        @if($stockMovement->item)
                            <a href="{{ route('items.show', $stockMovement->item) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                View Item Details
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
