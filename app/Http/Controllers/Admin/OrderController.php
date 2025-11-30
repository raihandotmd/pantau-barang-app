<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StockMovements;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use LogsActivity;

    public function index()
    {
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        $orders = Order::where('store_id', Auth::user()->store_id)
            ->with(['items.item'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->store_id !== Auth::user()->store_id) {
            abort(403);
        }
        
        $order->load(['items.item']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->store_id !== Auth::user()->store_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return back();
        }

        try {
            DB::beginTransaction();

            // Logic: Decrement stock ONLY when status changes to 'accepted'
            // If status was 'accepted' and changes to 'cancelled', we should probably restore stock?
            // For MVP, let's stick to: Accepted -> Decrement.
            
            if ($newStatus === 'accepted' && $oldStatus === 'pending') {
                foreach ($order->items as $orderItem) {
                    $item = $orderItem->item;
                    
                    // Check stock
                    if ($item->quantity < $orderItem->quantity) {
                        throw new \Exception("Insufficient stock for item: {$item->name}");
                    }

                    // Decrement Item Quantity
                    $item->decrement('quantity', $orderItem->quantity);

                    // Record Stock Movement
                    StockMovements::create([
                        'store_id' => $order->store_id,
                        'item_id' => $item->id,
                        'quantity_change' => $orderItem->quantity,
                        'type' => 'out',
                        'user_id' => Auth::id(),
                        'notes' => "Order #{$order->id} Accepted",
                    ]);
                }
            }
            
            // If cancelling an accepted order, restore stock
            if ($newStatus === 'cancelled' && ($oldStatus === 'accepted' || $oldStatus === 'completed')) {
                 foreach ($order->items as $orderItem) {
                    $item = $orderItem->item;
                    
                    // Increment Item Quantity
                    $item->increment('quantity', $orderItem->quantity);

                    // Record Stock Movement
                    StockMovements::create([
                        'store_id' => $order->store_id,
                        'item_id' => $item->id,
                        'quantity_change' => $orderItem->quantity,
                        'type' => 'in',
                        'user_id' => Auth::id(),
                        'notes' => "Order #{$order->id} Cancelled (Restock)",
                    ]);
                }
            }

            $order->update(['status' => $newStatus]);
            
            $this->logActivity('order_status_updated', "Order #{$order->id} status changed from {$oldStatus} to {$newStatus}");

            DB::commit();
            return redirect()->route('dashboard', ['tab' => 'pesanan'])->with('success', 'Order status updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }
}
