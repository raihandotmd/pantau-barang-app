<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Pending Orders</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $pendingOrders }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Low Stock Items</div>
                    <div class="text-3xl font-bold text-red-600">{{ $lowStockCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Orders</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Recent Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="py-2">#{{ $order->id }}</td>
                                        <td class="py-2">{{ $order->customer_name }}</td>
                                        <td class="py-2">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 text-right">
                            <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All Orders &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Geospatial Map -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order Distribution</h3>
                    <div id="dashboard-map" class="h-64 w-full rounded border border-gray-300"></div>
                </div>

            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('dashboard-map').setView([-6.200000, 106.816666], 11);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var locations = @json($orderLocations);
            
            locations.forEach(function(loc) {
                L.marker([loc.lat, loc.lng])
                    .addTo(map)
                    .bindPopup('<b>Order #' + loc.id + '</b><br>' + loc.name + '<br>Status: ' + loc.status);
            });

            if (locations.length > 0) {
                var group = new L.featureGroup(locations.map(loc => L.marker([loc.lat, loc.lng])));
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>
</x-app-layout>
