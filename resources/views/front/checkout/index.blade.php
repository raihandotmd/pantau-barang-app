<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-8">Checkout</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Cart Summary -->
                <div class="bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <div class="flex justify-between items-center border-b pb-4">
                                <div>
                                    <h3 class="font-medium">{{ $details['name'] }}</h3>
                                    <p class="text-sm text-gray-500">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-semibold">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center pt-4 font-bold text-lg">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Customer Details</h2>
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="customer_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                                <input type="text" name="customer_phone" required placeholder="0812..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Address</label>
                                <textarea name="customer_address" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pin Location (Optional)</label>
                                <p class="text-xs text-gray-500 mb-2">Click on the map to pin your exact location.</p>
                                <div id="map" class="h-64 w-full rounded border border-gray-300"></div>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 font-bold shadow-lg transition-transform transform hover:scale-105">
                                Place Order (COD)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Default to Jakarta or Store Location if available
            var map = L.map('map').setView([-6.200000, 106.816666], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map);
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
            
            // Try to get user location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                });
            }
        });
    </script>
</x-guest-layout>
