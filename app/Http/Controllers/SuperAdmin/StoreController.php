<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
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
        
        return view('super-admin.stores.index', compact('stores'));
    }

    public function approve(Request $request, Stores $store)
    {
        $status = $request->input('status', 'active');
        $store->update(['status' => $status]);
        
        $statusText = [
            'active' => 'aktif',
            'pending' => 'pending',
            'rejected' => 'ditolak'
        ];
        
        return back()->with('success', 'Status toko berhasil diubah menjadi ' . ($statusText[$status] ?? $status) . '.');
    }

    public function reject(Stores $store)
    {
        $store->update(['status' => 'rejected']);
        return back()->with('success', 'Toko berhasil ditolak.');
    }
}
