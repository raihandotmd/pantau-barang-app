<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Item: ') . $item->name }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('items.edit', $item) }}" 
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Item
                </a>
                <a href="{{ route('items.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Items
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Item Overview Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-8">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-r from-pantau-dark to-pantau-medium rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $item->name }}</h3>
                                <div class="flex items-center space-x-4 mt-2">
                                    @if($item->code)
                                        <span class="text-gray-600">Code: {{ $item->code }}</span>
                                    @endif
                                    @if($item->category)
                                        <span class="inline-flex px-3 py-1 text-sm font-medium bg-pantau-light/20 text-pantau-dark rounded-full">
                                            {{ $item->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Stock Status Badge -->
                        <div class="text-center">
                            @if($item->isLowStock())
                                <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full bg-red-100 text-red-800">
                                    Low Stock
                                </span>
                            @else
                                <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full bg-green-100 text-green-800">
                                    In Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Item Details Grid -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-pantau-sand/20 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-pantau-medium">{{ $item->quantity }}</div>
                            <div class="text-sm text-pantau-dark">Stock Quantity</div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            <div class="text-sm text-yellow-700">Unit Price</div>
                        </div>
                        <div class="bg-pantau-light/10 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-pantau-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            <div class="text-sm text-pantau-dark">Total Value</div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($item->description)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                            <p class="text-gray-900">{{ $item->description }}</p>
                        </div>
                    @endif

                    <!-- Item Details -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Created Date</div>
                                    <div class="font-semibold text-gray-900">{{ $item->created_at->format('F d, Y') }}</div>
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
                                    <div class="font-semibold text-gray-900">{{ $item->updated_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Stock Movements</div>
                                    <div class="font-semibold text-gray-900">{{ $item->stockMovements->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Movement History -->
            @if ($item->stockMovements->count() > 0)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Stock Movement History</h3>
                        <p class="text-gray-600">Track all stock changes for this item</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($item->stockMovements->sortByDesc('created_at') as $movement)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $movement->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($movement->type === 'in')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Stock In
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Stock Out
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($movement->type === 'in')
                                                <span class="text-green-600 font-medium">+{{ $movement->quantity_change }}</span>
                                            @else
                                                <span class="text-red-600 font-medium">-{{ $movement->quantity_change }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $movement->user ? $movement->user->name : 'System' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- No Stock Movements -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Stock Movements Yet</h3>
                        <p class="text-gray-500">Stock movements will appear here when quantities are adjusted.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>