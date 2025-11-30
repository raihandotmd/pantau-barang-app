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
    public function index(Request $request)
    {
        if (Auth::user()->is_super_admin) {
            return redirect()->route('super-admin.dashboard');
        }

        if (!Auth::user()->store_id) {
            return redirect()->route('store.create');
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
        // Recent stock movements
        $recentMovements = StockMovements::where('store_id', $storeId)
            ->with(['item', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'movements_page');

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

        // Order Stats
        $totalOrders = \App\Models\Order::where('store_id', $storeId)->count();
        $pendingOrders = \App\Models\Order::where('store_id', $storeId)->where('status', 'pending')->count();
        
        // Recent Orders
        // Orders with Search and Filter
        $ordersQuery = \App\Models\Order::where('store_id', $storeId)
            ->with('items.item');

        if ($request->has('search_order') && $request->search_order != '') {
            $search = $request->search_order;
            $ordersQuery->where(function($q) use ($search) {
                $q->where('customer_name', 'ilike', "%{$search}%")
                  ->orWhere('customer_phone', 'ilike', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->has('status_filter') && $request->status_filter != '' && $request->status_filter != 'all') {
            $ordersQuery->where('status', $request->status_filter);
        }

        $recentOrders = $ordersQuery->latest()->paginate(10, ['*'], 'orders_page');

        // Order Locations for Map
        $orderLocations = \App\Models\Order::where('store_id', $storeId)
            ->whereNotNull('location')
            ->get(['id', 'customer_name', 'location', 'status'])
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'name' => $order->customer_name,
                    'lat' => $order->location->getLatitude(),
                    'lng' => $order->location->getLongitude(),
                    'status' => $order->status,
                ];
            });

        // Total Revenue (Sum of completed orders)
        $totalRevenue = \App\Models\Order::where('store_id', $storeId)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Items with Search and Filter
        $itemsQuery = Items::where('store_id', $storeId)
            ->with('category');

        if ($request->has('search_item') && $request->search_item != '') {
            $search = $request->search_item;
            $itemsQuery->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('code', 'ilike', "%{$search}%");
            });
        }

        if ($request->has('category_filter') && $request->category_filter != '' && $request->category_filter != 'all') {
            $itemsQuery->where('category_id', $request->category_filter);
        }

        $items = $itemsQuery->orderBy('created_at', 'desc')->paginate(10);

        // Categories for Category Table (Paginated)
        // Categories for Category Table (Paginated)
        $categoriesQuery = Categories::where('store_id', $storeId)
            ->withCount('items');

        if ($request->has('search_category') && $request->search_category != '') {
            $search = $request->search_category;
            $categoriesQuery->where('name', 'ilike', "%{$search}%");
        }

        $categories = $categoriesQuery->orderBy('name')
            ->paginate(10, ['*'], 'categories_page');

        // All items for dropdown (not paginated)
        $allItems = Items::where('store_id', $storeId)->orderBy('name')->get();

        // All categories for dropdown (not paginated)
        $allCategories = Categories::where('store_id', $storeId)->orderBy('name')->get();

        $storeStatus = \App\Models\Stores::find($storeId)->status;

        return view('dashboard', compact(
            'storeStatus',
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
            'topCategories',
            'totalOrders',
            'pendingOrders',
            'recentOrders',
            'orderLocations',
            'totalRevenue',
            'items',
            'categories',
            'allItems',
            'allCategories'
        ));
    }
}
