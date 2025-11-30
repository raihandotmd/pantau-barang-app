@props(['name', 'show' => false])

<div
    x-data="{
        show: @js($show),
        order: null,
        map: null,
        marker: null,
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
        formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }).format(date);
        },
        initMap() {
            if (this.order && this.order.latitude && this.order.longitude) {
                this.$nextTick(() => {
                    if (!this.map) {
                        this.map = L.map('order-map-' + this.order.id).setView([this.order.latitude, this.order.longitude], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors'
                        }).addTo(this.map);
                        this.marker = L.marker([this.order.latitude, this.order.longitude]).addTo(this.map);
                    } else {
                        this.map.setView([this.order.latitude, this.order.longitude], 15);
                        if (this.marker) {
                            this.marker.setLatLng([this.order.latitude, this.order.longitude]);
                        } else {
                            this.marker = L.marker([this.order.latitude, this.order.longitude]).addTo(this.map);
                        }
                        this.map.invalidateSize();
                    }
                });
            }
        }
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
            initMap();
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="if ($event.detail.name == '{{ $name }}') { show = true; order = $event.detail.order; initMap(); }"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex items-center justify-center"
    style="display: none;"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="p-6" x-show="order">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Detail Pesanan #<span x-text="order?.id"></span></h3>
                    <p class="text-sm text-gray-500" x-text="order ? formatDate(order.created_at) : ''"></p>
                </div>
                <button x-on:click="show = false" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <!-- Customer Info & Map -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Informasi Pelanggan</h4>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Nama</p>
                            <p class="text-sm font-medium text-gray-900" x-text="order?.customer_name"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Telepon</p>
                            <p class="text-sm text-gray-900" x-text="order?.customer_phone"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Alamat</p>
                            <p class="text-sm text-gray-900" x-text="order?.customer_address || '-'"></p>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="h-48 bg-gray-100 rounded-lg overflow-hidden relative">
                    <div :id="'order-map-' + order?.id" class="h-full w-full z-0"></div>
                    <div x-show="!order?.latitude" class="absolute inset-0 flex items-center justify-center text-gray-500 text-sm">
                        Data lokasi tidak tersedia
                    </div>
                </div>
            </div>

            <!-- Status Update -->
            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                <form :action="'/orders/' + order?.id + '/status'" method="POST" class="flex items-end gap-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Perbarui Status</label>
                        <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" :selected="order?.status === 'pending'">Menunggu (Pending)</option>
                            <option value="accepted" :selected="order?.status === 'accepted'">Diterima (Accepted)</option>
                            <option value="completed" :selected="order?.status === 'completed'">Selesai (Completed)</option>
                            <option value="cancelled" :selected="order?.status === 'cancelled'">Dibatalkan (Cancelled)</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Perbarui
                    </button>
                </form>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Barang Dipesan</h4>
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Jml</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="item in order?.items" :key="item.id">
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900" x-text="item.item?.name || 'Barang Tidak Diketahui'"></td>
                                    <td class="px-4 py-2 text-sm text-gray-900 text-right" x-text="item.quantity"></td>
                                    <td class="px-4 py-2 text-sm text-gray-900 text-right">Rp <span x-text="formatPrice(item.price)"></span></td>
                                    <td class="px-4 py-2 text-sm text-gray-900 text-right font-medium">Rp <span x-text="formatPrice(item.price * item.quantity)"></span></td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Total Harga</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Rp <span x-text="order ? formatPrice(order.total_amount) : 0"></span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button x-on:click="show = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
