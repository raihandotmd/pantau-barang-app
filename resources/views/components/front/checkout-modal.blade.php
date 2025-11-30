<div x-data="{ 
    open: false,
    loading: false,
    form: {
        customer_name: '',
        customer_phone: '',
        customer_address: '',
        latitude: '',
        longitude: ''
    },
    initMap() {
        if (this.map) return;
        
        setTimeout(() => {
            if (!this.map) {
                this.map = L.map('checkout-map').setView([-6.200000, 106.816666], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(this.map);

                this.map.on('click', (e) => {
                    const { lat, lng } = e.latlng;
                    if (this.marker) this.map.removeLayer(this.marker);
                    this.marker = L.marker([lat, lng]).addTo(this.map);
                    this.form.latitude = lat;
                    this.form.longitude = lng;
                });

                // Add Geocoder Control
                if (L.Control.geocoder) {
                    L.Control.geocoder({
                        defaultMarkGeocode: false
                    })
                    .on('markgeocode', (e) => {
                        const bbox = e.geocode.bbox;
                        const poly = L.polygon([
                            bbox.getSouthEast(),
                            bbox.getNorthEast(),
                            bbox.getNorthWest(),
                            bbox.getSouthWest()
                        ]).addTo(this.map);
                        this.map.fitBounds(poly.getBounds());
                        
                        const { lat, lng } = e.geocode.center;
                        if (this.marker) this.map.removeLayer(this.marker);
                        this.marker = L.marker([lat, lng]).addTo(this.map);
                        this.form.latitude = lat;
                        this.form.longitude = lng;
                        this.form.customer_address = e.geocode.name;
                    })
                    .addTo(this.map);
                }

                // Add Locate Control
                if (L.control.locate) {
                    L.control.locate({
                        position: 'topleft',
                        setView: 'untilPan',
                        flyTo: true,
                        strings: {
                            title: 'Show me where I am'
                        },
                        locateOptions: {
                            enableHighAccuracy: true
                        }
                    }).addTo(this.map);
                }

                // Listen for location found event from Locate Control
                this.map.on('locationfound', (e) => {
                    const { lat, lng } = e.latlng;
                    if (this.marker) this.map.removeLayer(this.marker);
                    this.marker = L.marker([lat, lng]).addTo(this.map);
                    this.form.latitude = lat;
                    this.form.longitude = lng;
                });

                // Try to get user location initially if not using the control
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const { latitude, longitude } = position.coords;
                        // Only set view if not already set by user interaction
                        if (!this.form.latitude) {
                            this.map.setView([latitude, longitude], 15);
                        }
                    });
                }
            } else {
                this.map.invalidateSize();
            }
        }, 300);
    },
    submitOrder() {
        this.loading = true;
        fetch('{{ route('checkout.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(this.form)
        })
        .then(response => response.json())
        .then(data => {
            this.loading = false;
            if (data.success) {
                alert(data.message);
                this.open = false;
                // Reset cart
                window.location.reload(); // Simplest way to clear state and refresh
            } else {
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(error => {
            this.loading = false;
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}" 
@open-checkout.window="open = true; initMap()"
@keydown.escape.window="open = false"
class="relative z-[70]"
x-show="open"
style="display: none;">

    <div x-show="open" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">Checkout</h3>
                            <div class="mt-2 text-sm text-gray-500">
                                Please fill in your details to complete the order.
                            </div>

                            <form @submit.prevent="submitOrder" class="mt-6 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" x-model="form.customer_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                                        <input type="text" x-model="form.customer_phone" required placeholder="08..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea x-model="form.customer_address" rows="2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pin Location</label>
                                    <div id="checkout-map" class="h-64 w-full rounded-lg border border-gray-300"></div>
                                </div>

                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                    <button type="submit" 
                                        :disabled="loading"
                                        :class="{ 'opacity-50 cursor-not-allowed': loading }"
                                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                                        <span x-show="!loading">Place Order</span>
                                        <span x-show="loading">Processing...</span>
                                    </button>
                                    <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
