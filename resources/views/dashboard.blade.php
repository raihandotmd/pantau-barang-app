<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if(Auth::user()->store_id)
            <span class="text-sm text-gray-600">
                Store: <span class="font-semibold">{{ Auth::user()->store->name }}</span>
            </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!Auth::user()->store_id)
                <!-- No Store - Show Create Store Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 overflow-hidden shadow-lg sm:rounded-lg border border-blue-200">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome to Pantau Barang!</h3>
                                    <p class="text-gray-700 text-lg mb-1">Get started by creating your store</p>
                                    <p class="text-gray-600">Manage your inventory, track stock, and grow your business</p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('store.create') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- User Has Store - Show Store Dashboard -->
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Items -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Total Items</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalItems }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Categories -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Categories</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Value -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Inventory Value</p>
                                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-600">Low Stock Items</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $lowStockCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Movement Summary -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Movement Summary (Last 7 Days)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-1">Stock In</p>
                                <p class="text-3xl font-bold text-green-600">+{{ $stockInLast7Days }}</p>
                            </div>
                            <div class="text-center p-4 bg-red-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-1">Stock Out</p>
                                <p class="text-3xl font-bold text-red-600">-{{ $stockOutLast7Days }}</p>
                            </div>
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-1">Net Change</p>
                                <p class="text-3xl font-bold {{ ($stockInLast7Days - $stockOutLast7Days) >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    {{ $stockInLast7Days - $stockOutLast7Days >= 0 ? '+' : '' }}{{ $stockInLast7Days - $stockOutLast7Days }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Low Stock Items -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Low Stock Alert</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    {{ $lowStockCount }} items
                                </span>
                            </div>

                            @if($lowStockItems->count() > 0)
                                <div class="space-y-3">
                                    @foreach($lowStockItems as $item)
                                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $item->category->name ?? 'Uncategorized' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-red-600">{{ $item->quantity }} {{ $item->unit }}</p>
                                                <p class="text-xs text-gray-500">Low Stock</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">All items are well stocked!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Out of Stock Items -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Out of Stock</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ $outOfStockCount }} items
                                </span>
                            </div>

                            @if($outOfStockCount > 0)
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-900 font-medium">{{ $outOfStockCount }} items need restocking</p>
                                    <a href="{{ route('items.index') }}?filter=out-of-stock" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                                        View out of stock items →
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">No items out of stock!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Top Categories -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Categories</h3>
                        
                        @if($topCategories->count() > 0)
                            <div class="space-y-4">
                                @foreach($topCategories as $category)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $category->name }}</p>
                                            <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalItems > 0 ? ($category->items_count / $totalItems) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <p class="text-lg font-bold text-gray-900">{{ $category->items_count }}</p>
                                            <p class="text-xs text-gray-500">items</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">No categories yet</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Stock Movements and Activity Logs -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                    <!-- Recent Stock Movements -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Stock Movements</h3>
                                <a href="{{ route('stock-movements.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all →</a>
                            </div>

                            @if($recentMovements->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentMovements as $movement)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">{{ $movement->item->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $movement->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity_change }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-4">No movements yet</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Activity Logs -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                            </div>

                            @if($recentActivities->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentActivities as $activity)
                                        <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->action }}</p>
                                                <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-4">No activity yet</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg mt-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('items.create') }}" class="flex items-center p-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition duration-200">
                                <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-white">Add Item</p>
                                    <p class="text-sm text-blue-100">Create new product</p>
                                </div>
                            </a>

                            <a href="{{ route('stock-movements.create') }}" class="flex items-center p-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition duration-200">
                                <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-white">Record Movement</p>
                                    <p class="text-sm text-blue-100">Update stock levels</p>
                                </div>
                            </a>

                            <a href="{{ route('categories.index') }}" class="flex items-center p-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition duration-200">
                                <svg class="w-8 h-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <div>
                                    <p class="font-semibold text-white">Manage Categories</p>
                                    <p class="text-sm text-blue-100">Organize products</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
