<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::count();
        $totalStores = Stores::count();
        $pendingStores = Stores::where('status', 'pending')->count();
        $activeStores = Stores::where('status', 'active')->count();

        // Fetch stores with search and filter
        $query = Stores::query();

        // Search by name or slug
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('slug', 'ilike', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $stores = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('super-admin.dashboard', compact('totalUsers', 'totalStores', 'pendingStores', 'activeStores', 'stores'));
    }
}
