<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }} #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Order Info -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Items</h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="py-3">{{ $item->item->name }}</td>
                                            <td class="py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="py-3">{{ $item->quantity }}</td>
                                            <td class="py-3">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-bold">
                                        <td colspan="3" class="py-3 text-right">Total:</td>
                                        <td class="py-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                            
                            @if($order->location)
                                <div class="mt-4 h-64 w-full rounded" id="map"></div>
                                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var map = L.map('map').setView([{{ $order->location->getLatitude() }}, {{ $order->location->getLongitude() }}], 15);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '© OpenStreetMap contributors'
                                        }).addTo(map);
                                        L.marker([{{ $order->location->getLatitude() }}, {{ $order->location->getLongitude() }}]).addTo(map)
                                            .bindPopup('Customer Location')
                                            .openPopup();
                                    });
                                </script>
                            @else
                                <p class="mt-4 text-gray-500 italic">No location coordinates provided.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Management -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Order Status</h3>
                            <div class="mb-4">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pantau-medium focus:ring-pantau-medium">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted (Deduct Stock)</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled (Restore Stock)</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pantau-medium hover:bg-pantau-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pantau-medium">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
