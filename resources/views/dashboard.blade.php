<x-app-layout>

    <div class="py-12" x-data="{ activeTab: 'inventaris' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <x-dashboard.welcome-banner />

            <!-- Stats Cards -->
            <x-dashboard.stats-cards 
                :totalItems="$totalItems" 
                :pendingOrders="$pendingOrders" 
                :lowStockCount="$lowStockCount" 
                :totalRevenue="$totalRevenue" 
            />

            <!-- Tabs Navigation -->
            <x-dashboard.tabs-navigation />

            <!-- Tab Contents -->
            <x-dashboard.tabs.inventaris :items="$items" />
            
            <x-dashboard.tabs.kategori :categories="$categories" />
            
            <x-dashboard.tabs.pesanan :recentOrders="$recentOrders" />
            
            <x-dashboard.tabs.riwayat-stok :recentMovements="$recentMovements" />
            
            <x-dashboard.tabs.laporan 
                :stockInLast7Days="$stockInLast7Days" 
                :stockOutLast7Days="$stockOutLast7Days" 
            />

        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map only when tab is shown or immediately but handle resize
            // Center on Indonesia (approx -2.5, 118) with zoom 5
            var map = L.map('dashboard-map').setView([-2.5489, 118.0149], 5);
            
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

            // Fix map rendering when tab is switched
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
            
            // Watch for tab changes to invalidate map size
            // Since we use Alpine, we can hook into x-effect or just rely on click
            document.querySelector('[@click="activeTab = \'laporan\'"]').addEventListener('click', function() {
                setTimeout(function() {
                    map.invalidateSize();
                    if (locations.length > 0) {
                        var group = new L.featureGroup(locations.map(loc => L.marker([loc.lat, loc.lng])));
                        map.fitBounds(group.getBounds().pad(0.1), { maxZoom: 15 });
                    }
                }, 100);
            });
        });
    </script>

    <!-- Modals -->
    <x-modal name="create-category" :show="$errors->has('name') && !$errors->has('price')" focusable>
        <x-forms.category-create />
    </x-modal>

    <x-modal name="create-item" :show="$errors->has('price') || ($errors->has('name') && $errors->has('price')) || $errors->has('code') || $errors->has('quantity')" focusable>
        <x-forms.item-create :categories="$categories" />
    </x-modal>

    <x-modal name="create-stock-movement" :show="$errors->has('item_id') || $errors->has('type') || $errors->has('quantity_change') || $errors->has('notes')" focusable>
        <x-forms.stock-movement-create :items="$allItems" />
    </x-modal>

</x-app-layout>
