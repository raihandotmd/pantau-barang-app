<x-app-layout>

    <div class="py-12" x-data="{ 
        activeTab: '{{ request('tab', 'inventaris') }}',
        init() {
            this.$watch('activeTab', value => {
                if (value === 'laporan') {
                    setTimeout(() => {
                        if (window.dashboardMap) {
                            window.dashboardMap.invalidateSize();
                            if (window.mapBounds) {
                                window.dashboardMap.fitBounds(window.mapBounds.pad(0.1), { maxZoom: 15 });
                            }
                        }
                    }, 100);
                }
            });
        }
    }">
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
            <x-dashboard.tabs.inventaris :items="$items" :categories="$allCategories" />
            
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
            // Initialize map
            var map = L.map('dashboard-map').setView([-2.5489, 118.0149], 5);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var locations = @json($orderLocations);
            var markers = [];
            
            locations.forEach(function(loc) {
                var marker = L.marker([loc.lat, loc.lng])
                    .addTo(map)
                    .bindPopup('<b>Order #' + loc.id + '</b><br>' + loc.name + '<br>Status: ' + loc.status);
                markers.push(marker);
            });

            // Make map accessible globally for Alpine to use
            window.dashboardMap = map;
            window.mapLocations = locations;
            window.mapMarkers = markers;

            if (locations.length > 0) {
                var group = new L.featureGroup(markers);
                window.mapBounds = group.getBounds();
                map.fitBounds(window.mapBounds.pad(0.1));
            }

            // Fix map rendering when window is resized
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        });
    </script>

    <!-- Modals -->
    <x-modal name="create-category" :show="$errors->has('name') && !$errors->has('price')" focusable maxWidth="lg">
        <x-forms.category-create />
    </x-modal>

    <x-modal name="create-item" :show="$errors->has('price') || ($errors->has('name') && $errors->has('price')) || $errors->has('code') || $errors->has('quantity')" focusable maxWidth="lg">
        <x-forms.item-create :categories="$categories" />
    </x-modal>

    <x-modal name="create-stock-movement" :show="$errors->has('item_id') || $errors->has('type') || $errors->has('quantity_change') || $errors->has('notes')" focusable maxWidth="lg">
        <x-forms.stock-movement-create :items="$allItems" />
    </x-modal>

    <x-modal name="edit-item" :show="$errors->has('name') || $errors->has('price') || $errors->has('quantity')" focusable>
        <x-forms.item-edit :categories="$allCategories" />
    </x-modal>

    <x-modal name="edit-category" :show="$errors->has('name') && !$errors->has('price')" focusable>
        <x-forms.category-edit />
    </x-modal>

    <x-modals.order-detail name="order-detail" />

</x-app-layout>
