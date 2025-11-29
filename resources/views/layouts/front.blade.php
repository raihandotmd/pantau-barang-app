<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pantau Barang') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50"
        x-data="{
            cart: {{ json_encode(session('cart', [])) }},
            cartCount: {{ count(session('cart', [])) }},
            cartTotal: {{ array_reduce(session('cart', []), function($carry, $item) { return $carry + ($item['price'] * $item['quantity']); }, 0) }},
            mobileMenuOpen: false,
            
            addToCart(itemId) {
                fetch(`/cart/add/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        this.cart = data.cart;
                        this.cartCount = data.cart_count;
                        this.updateTotal();
                        $dispatch('open-cart');
                    }
                });
            },
            
            removeFromCart(itemId) {
                fetch(`/cart/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id: itemId })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        this.cart = data.cart;
                        this.cartCount = data.cart_count;
                        this.updateTotal();
                    }
                });
            },

            updateTotal() {
                this.cartTotal = Object.values(this.cart).reduce((acc, item) => acc + (item.price * item.quantity), 0);
            },

            buyNow(itemId) {
                this.addToCart(itemId);
                setTimeout(() => {
                    $dispatch('open-checkout');
                }, 500);
            }
        }">

        {{ $slot }}

        <!-- Components -->
        <x-front.cart-drawer />
        <x-front.checkout-modal />
        
        @stack('scripts')
    </body>
</html>
