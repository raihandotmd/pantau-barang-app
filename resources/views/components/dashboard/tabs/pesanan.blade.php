@props(['recentOrders'])

<div x-show="activeTab === 'pesanan'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6" style="display: none;">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h3 class="text-lg font-bold text-gray-900">Daftar Pesanan</h3>
        
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <!-- Preserve active tab -->
            <input type="hidden" name="tab" value="pesanan">
            
            <div class="relative">
                <input type="text" name="search_order" value="{{ request('search_order') }}" placeholder="Cari pelanggan..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <select name="status_filter" onchange="this.form.submit()" class="border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 pl-3 pr-8">
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status_filter') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="accepted" {{ request('status_filter') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                <option value="completed" {{ request('status_filter') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status_filter') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            
            <button type="submit" class="hidden sm:inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                @if($order->status === 'pending') Menunggu
                                @elseif($order->status === 'accepted') Diterima
                                @elseif($order->status === 'completed') Selesai
                                @elseif($order->status === 'cancelled') Dibatalkan
                                @else {{ ucfirst($order->status) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', { name: 'order-detail', order: {{ $order }} })" class="text-indigo-600 hover:text-indigo-900">Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pesanan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $recentOrders->appends(['tab' => 'pesanan', 'search_order' => request('search_order'), 'status_filter' => request('status_filter')])->links() }}
        </div>
    </div>
</div>
