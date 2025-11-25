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
    public function index(Request $request)
    {
        // Simple Cart Implementation using Session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('catalog.index')->with('info', 'Your cart is empty.');
        }

        $store = Stores::first(); // Assuming single store context

        return view('front.checkout.index', compact('cart', 'store'));
    }

    public function addToCart(Request $request, Items $item)
    {
        $cart = session()->get('cart', []);
        
        $id = $item->id;
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
                'image' => $item->image_path,
                'category' => $item->category->name ?? 'Uncategorized'
            ];
        }
        
        session()->put('cart', $cart);
        
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

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
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

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $cart = session()->get('cart');
        if (empty($cart)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cart is empty.'], 400);
            }
            return redirect()->route('catalog.index')->with('error', 'Cart is empty.');
        }

        $store = Stores::first();

        try {
            DB::beginTransaction();

            // Create Order
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

            // Clear Cart
            session()->forget('cart');

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Order placed successfully! We will contact you shortly.',
                    'order_id' => $order->id
                ]);
            }

            return redirect()->route('catalog.index')->with('success', 'Order placed successfully! We will contact you shortly.');

        } catch (\Exception $e) {
            DB::rollback();
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
