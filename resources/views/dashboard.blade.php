<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (!Auth::user()->store_id)
                <!-- No Store - Show Create Store Card -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-indigo-100 overflow-hidden shadow-lg sm:rounded-lg border border-blue-200">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}!</h3>
                                    <p class="text-gray-600 text-lg mt-1">Ready to set up your store and start managing
                                        inventory?</p>
                                    <p class="text-gray-500 mt-2">Create your store to begin tracking items, managing stock,
                                        and monitoring your business.</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('store.create') }}"
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Your Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="grid md:grid-cols-3 gap-6 mt-8">
                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900 text-lg">Inventory Management</h4>
                                <p class="text-gray-600 text-sm mt-1">Track your items and stock levels easily</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900 text-lg">Stock Monitoring</h4>
                                <p class="text-gray-600 text-sm mt-1">Get alerts when items run low</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-900 text-lg">Activity Logs</h4>
                                <p class="text-gray-600 text-sm mt-1">Track all changes and movements</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- User Has Store - Show Store Dashboard -->
                @php
                    $store = \App\Models\Stores::find(Auth::user()->store_id);
                @endphp

                @if($store)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                        <div class="bg-gradient-to-r from-green-500 to-blue-600 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-white">{{ $store->name }}</h3>
                                    <p class="text-green-100 mt-1">{{ $store->contact_info }}</p>
                                    @if($store->address)
                                        <p class="text-green-100 text-sm mt-1">📍 {{ Str::limit($store->address, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-6">
                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Quick Stats Cards -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-500">Total Items</p>
                                            <p class="text-lg font-semibold text-gray-900">0</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-500">In Stock</p>
                                            <p class="text-lg font-semibold text-gray-900">0</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-500">Low Stock</p>
                                            <p class="text-lg font-semibold text-gray-900">0</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-500">Categories</p>
                                            <p class="text-lg font-semibold text-gray-900">0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h4>
                                <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
                                    <button
                                        class="flex items-center justify-center px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Item
                                    </button>

                                    <a href="{{ route('categories.create') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Add Category
                                    </a>

                                    <a href="{{ route('categories.index') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                            </path>
                                        </svg>
                                        View Categories
                                    </a>

                                    <button
                                        class="flex items-center justify-center px-4 py-3 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        Reports
                                    </button>

                                    <button
                                        class="flex items-center justify-center px-4 py-3 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
