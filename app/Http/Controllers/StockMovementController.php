<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockMovementRequest;
use App\Models\Items;
use App\Models\StockMovements;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of stock movements.
     */
    public function index(Request $request)
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        $query = StockMovements::where('store_id', Auth::user()->store_id)
            ->with(['item', 'user']);

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['in', 'out'])) {
            $query->where('type', $request->type);
        }

        // Filter by item
        if ($request->has('item_id') && $request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get items for filter dropdown
        $items = Items::where('store_id', Auth::user()->store_id)
            ->orderBy('name')
            ->get();

        return view('stock-movements.index', compact('movements', 'items'));
    }

    /**
     * Show the form for creating a new stock movement.
     */
    public function create()
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        // Get items for dropdown
        $items = Items::where('store_id', Auth::user()->store_id)
            ->orderBy('name')
            ->get();

        return view('stock-movements.create', compact('items'));
    }

    /**
     * Store a newly created stock movement.
     */
    public function store(StoreStockMovementRequest $request)
    {
        try {
            DB::beginTransaction();

            $item = Items::where('id', $request->item_id)
                ->where('store_id', Auth::user()->store_id)
                ->firstOrFail();

            // Create stock movement
            $movement = StockMovements::create([
                'store_id' => Auth::user()->store_id,
                'item_id' => $request->item_id,
                'quantity_change' => $request->quantity_change,
                'type' => $request->type,
                'notes' => $request->notes,
                'user_id' => Auth::id(),
            ]);

            // Update item quantity
            if ($request->type === 'in') {
                $item->increment('quantity', $request->quantity_change);
            } else {
                // Check if there's enough stock
                if ($item->quantity < $request->quantity_change) {
                    DB::rollback();
                    return back()->withInput()->with('error', 'Insufficient stock. Current stock: ' . $item->quantity);
                }
                $item->decrement('quantity', $request->quantity_change);
            }

            // Log activity
            $typeLabel = $request->type === 'in' ? 'Stock In' : 'Stock Out';
            $this->logActivity(
                'stock_movement_' . $request->type,
                "{$typeLabel}: {$item->name} ({$request->quantity_change} units)" . ($request->notes ? " - {$request->notes}" : "")
            );

            DB::commit();

            return redirect()->route('stock-movements.index')->with('success', 'Stock movement recorded successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to record stock movement. Please try again.');
        }
    }

    /**
     * Display the specified stock movement.
     */
    public function show(StockMovements $stockMovement)
    {
        // Check if movement belongs to user's store
        if ($stockMovement->store_id !== Auth::user()->store_id) {
            return redirect()->route('stock-movements.index')->with('error', 'Stock movement not found.');
        }

        $stockMovement->load(['item', 'user']);

        return view('stock-movements.show', compact('stockMovement'));
    }
}
