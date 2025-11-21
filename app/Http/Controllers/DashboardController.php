<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Categories;
use App\Models\StockMovements;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        $storeId = Auth::user()->store_id;

        // Total items count
        $totalItems = Items::where('store_id', $storeId)->count();

        // Total categories count
        $totalCategories = Categories::where('store_id', $storeId)->count();

        // Total inventory value (using quantity from items table)
        $inventoryValue = Items::where('store_id', $storeId)
            ->select(DB::raw('SUM(price * quantity) as total'))
            ->value('total') ?? 0;

        // Low stock items (quantity <= 10) - using quantity from items table
        $lowStockThreshold = 10;
        $lowStockItems = Items::where('store_id', $storeId)
            ->where('quantity', '<=', $lowStockThreshold)
            ->where('quantity', '>', 0)
            ->with('category')
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get();

        $lowStockCount = Items::where('store_id', $storeId)
            ->where('quantity', '<=', $lowStockThreshold)
            ->where('quantity', '>', 0)
            ->count();

        // Out of stock items
        $outOfStockCount = Items::where('store_id', $storeId)
            ->where('quantity', 0)
            ->count();

        // Recent stock movements
        $recentMovements = StockMovements::where('store_id', $storeId)
            ->with(['item', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent activities
        $recentActivities = ActivityLogs::where('store_id', $storeId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Stock movements summary (last 7 days)
        $stockInLast7Days = StockMovements::where('store_id', $storeId)
            ->where('type', 'in')
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('quantity_change');

        $stockOutLast7Days = StockMovements::where('store_id', $storeId)
            ->where('type', 'out')
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('quantity_change');

        // Top categories by item count
        $topCategories = Categories::where('store_id', $storeId)
            ->withCount('items')
            ->orderBy('items_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalItems',
            'totalCategories',
            'inventoryValue',
            'lowStockItems',
            'lowStockCount',
            'outOfStockCount',
            'recentMovements',
            'recentActivities',
            'stockInLast7Days',
            'stockOutLast7Days',
            'topCategories'
        ));
    }
}
