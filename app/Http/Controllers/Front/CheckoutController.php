<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stores;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Get store by slug or fail
     */
    private function getStore(string $slug): Stores
    {
        return Stores::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
    }

    /**
     * Get cart key for store-specific cart
     */
    private function getCartKey(int $storeId): string
    {
        return "cart.{$storeId}";
    }

    public function index(Request $request, string $slug)
    {
        $store = $this->getStore($slug);
        $cart = session()->get($this->getCartKey($store->id), []);

        if (empty($cart)) {
            return redirect()->route('store.products', $slug)->with('info', 'Your cart is empty.');
        }

        return view('front.checkout.index', compact('cart', 'store'));
    }

    public function addToCart(Request $request, string $slug, Items $item)
    {
        $store = $this->getStore($slug);

        // Verify item belongs to this store
        if ($item->store_id !== $store->id) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Item not found in this store.'], 404);
            }
            return redirect()->back()->with('error', 'Item not found in this store.');
        }

        $cartKey = $this->getCartKey($store->id);
        $cart = session()->get($cartKey, []);

        $id = $item->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
                'image' => $item->image,
                'category' => $item->category->name ?? 'Uncategorized'
            ];
        }

        session()->put($cartKey, $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => count($cart),
                'cart' => $cart
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function removeFromCart(Request $request, string $slug)
    {
        $store = $this->getStore($slug);
        $cartKey = $this->getCartKey($store->id);

        if ($request->id) {
            $cart = session()->get($cartKey, []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put($cartKey, $cart);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart.',
                    'cart_count' => count($cart),
                    'cart' => $cart
                ]);
            }

            return redirect()->back()->with('success', 'Item removed from cart.');
        }
    }

    public function updateCart(Request $request, string $slug)
    {
        $store = $this->getStore($slug);
        $cartKey = $this->getCartKey($store->id);

        if ($request->id && $request->quantity) {
            $cart = session()->get($cartKey, []);
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $request->quantity;

                // If quantity is 0 or less, remove item
                if ($cart[$request->id]['quantity'] <= 0) {
                    unset($cart[$request->id]);
                }

                session()->put($cartKey, $cart);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated.',
                    'cart_count' => count($cart),
                    'cart' => $cart
                ]);
            }

            return redirect()->back()->with('success', 'Cart updated.');
        }
    }

    public function store(Request $request, string $slug)
    {
        $store = $this->getStore($slug);
        $cartKey = $this->getCartKey($store->id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $cart = session()->get($cartKey, []);
        if (empty($cart)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cart is empty.'], 400);
            }
            return redirect()->route('store.products', $slug)->with('error', 'Cart is empty.');
        }

        try {
            DB::beginTransaction();

            // Create Order with correct store_id
            $order = new Order();
            $order->store_id = $store->id;
            $order->customer_name = $request->customer_name;
            $order->customer_phone = $request->customer_phone;
            $order->customer_address = $request->customer_address;
            $order->status = 'pending';

            // Handle Location if provided
            if ($request->latitude && $request->longitude) {
                $order->location = Point::make($request->longitude, $request->latitude);
            }

            // Calculate Total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $order->total_amount = $total;

            $order->save();

            // Create Order Items
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            // Clear Cart for this store only
            session()->forget($cartKey);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully! We will contact you shortly.',
                    'order_id' => $order->id
                ]);
            }

            return redirect()->route('store.show', $slug)->with('success', 'Order placed successfully! We will contact you shortly.');

        } catch (\Exception $e) {
            DB::rollback();

            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
