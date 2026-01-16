@props(['store' => null])

<div x-data="{ open: false }" @open-cart.window="open = true" @keydown.escape.window="open = false"
    class="relative z-[60]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-show="open"
    style="display: none;">

    <!-- Background backdrop -->
    <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

    <div class="fixed inset-0 overflow-hidden z-50 pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                <!-- Slide-over panel -->
                <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-md">

                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Keranjang Belanja
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" @click="open = false"
                                        class="relative -m-2 p-2 text-gray-400 hover:text-gray-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Tutup panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <template x-for="(item, id) in cart" :key="id">
                                            <li class="flex py-6">
                                                <div
                                                    class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                                    <template x-if="item.image">
                                                        <img :src="'/storage/' + item.image" :alt="item.name"
                                                            class="h-full w-full object-cover object-center">
                                                    </template>
                                                    <template x-if="!item.image">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </template>
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col">
                                                    <div>
                                                        <div
                                                            class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3>
                                                                <a href="#" x-text="item.name"></a>
                                                            </h3>
                                                            <p class="ml-4"
                                                                x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(item.price * item.quantity)">
                                                            </p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500" x-text="item.category">
                                                        </p>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm">
                                                        <div
                                                            class="flex items-center border border-gray-300 rounded-md">
                                                            <button @click="updateCartQuantity(item.id, -1)"
                                                                class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-l-md transition-colors">-</button>
                                                            <span
                                                                class="px-2 py-1 text-gray-900 font-medium min-w-[2rem] text-center"
                                                                x-text="item.quantity"></span>
                                                            <button @click="updateCartQuantity(item.id, 1)"
                                                                class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-r-md transition-colors">+</button>
                                                        </div>

                                                        <div class="flex">
                                                            <button type="button" @click="removeFromCart(item.id)"
                                                                class="font-medium text-pantau-medium hover:text-pantau-dark">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>

                                        <li x-show="cartCount === 0" class="py-12 text-center text-gray-500">
                                            Keranjang belanja Anda kosong.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6" x-show="cartCount > 0">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(cartTotal)"></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Ongkos kirim dihitung saat checkout.</p>
                            <div class="mt-6">
                                <button @click="open = false; $dispatch('open-checkout')"
                                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-pantau-medium px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-pantau-dark transition-colors">Checkout</button>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>
                                    atau
                                    <button type="button" class="font-medium text-pantau-medium hover:text-pantau-dark"
                                        @click="open = false">
                                        Lanjut Belanja
                                        <span aria-hidden="true"> &rarr;</span>
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>