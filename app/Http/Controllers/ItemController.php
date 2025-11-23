<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Items;
use App\Models\Categories;
use App\Models\StockMovements;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        $query = Items::where('store_id', Auth::user()->store_id)
            ->with('category'); // Only load category, not all stock movements

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Stock status filter
        if ($request->has('stock_status') && $request->stock_status) {
            // This will be handled in the view since we need calculated stock
        }

        $items = $query->orderBy('name')->paginate(12);
        
        // Get categories for filter dropdown
        $categories = Categories::where('store_id', Auth::user()->store_id)
            ->orderBy('name')
            ->get();

        return view('items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        // Get categories for dropdown
        $categories = Categories::where('store_id', Auth::user()->store_id)
            ->orderBy('name')
            ->get();

        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(StoreItemRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the item
            $item = Items::create([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'store_id' => Auth::user()->store_id,
                'category_id' => $request->category_id,
            ]);

            // Create initial stock movement if quantity > 0
            if ($request->quantity > 0) {
                StockMovements::create([
                    'store_id' => Auth::user()->store_id,
                    'item_id' => $item->id,
                    'quantity_change' => $request->quantity,
                    'type' => 'in',
                    'user_id' => Auth::id(),
                ]);
            }

            // Log activity
            $this->logActivity('item_created', "Created item: {$item->name} (Code: {$item->code})");

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Item created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to create item. Please try again.');
        }
    }

    /**
     * Display the specified item.
     */
    public function show(Items $item)
    {
        // Check if item belongs to user's store
        if ($item->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Item not found.');
        }

        $item->load(['category', 'stockMovements.user']);

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Items $item)
    {
        // Check if item belongs to user's store
        if ($item->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Item not found.');
        }

        // Get categories for dropdown
        $categories = Categories::where('store_id', Auth::user()->store_id)
            ->orderBy('name')
            ->get();

        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(UpdateItemRequest $request, Items $item)
    {
        // Check if item belongs to user's store
        if ($item->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Item not found.');
        }

        try {
            DB::beginTransaction();

            $oldQuantity = $item->quantity;

            // Update the item
            $item->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
            ]);

            // Create stock movement if quantity changed
            $quantityDifference = $request->quantity - $oldQuantity;
            if ($quantityDifference != 0) {
                StockMovements::create([
                    'store_id' => Auth::user()->store_id,
                    'item_id' => $item->id,
                    'quantity_change' => abs($quantityDifference),
                    'type' => $quantityDifference > 0 ? 'in' : 'out',
                    'user_id' => Auth::id(),
                ]);
            }

            // Log activity
            $this->logActivity('item_updated', "Updated item: {$item->name} (Quantity: {$oldQuantity} → {$request->quantity})");

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Item updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to update item. Please try again.');
        }
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Items $item)
    {
        // Check if item belongs to user's store
        if ($item->store_id !== Auth::user()->store_id) {
            return redirect()->route('items.index')->with('error', 'Item not found.');
        }

        try {
            DB::beginTransaction();
            
            $itemName = $item->name;
            $itemCode = $item->code;
            
            // Delete item - stock movements will cascade delete automatically
            // This is correct behavior defined in migration: ->onDelete('cascade')
            $item->delete();

            // Log activity
            $this->logActivity('item_deleted', "Deleted item: {$itemName} (Code: {$itemCode})");

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Item deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to delete item. ' . $e->getMessage());
        }
    }
}