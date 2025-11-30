<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($slug)
    {
        $store = Stores::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        $items = Items::where('store_id', $store->id)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact('store', 'items'));
    }

    public function products(Request $request, $slug)
    {
        $store = Stores::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        $query = Items::where('store_id', $store->id)
            ->where('quantity', '>', 0);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $items = $query->latest()->paginate(12);
        $categories = \App\Models\Categories::where('store_id', $store->id)->get();

        return view('front.products.index', compact('store', 'items', 'categories'));
    }

    public function profile($slug)
    {
        $store = Stores::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('front.store-profile', compact('store'));
    }
}
