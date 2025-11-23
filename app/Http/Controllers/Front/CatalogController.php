<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Items;
use App\Models\Stores;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // For MVP, we assume single store or show all. 
        // Let's assume we show items from the first store found or specific store if slug provided.
        // Since requirements mention "UMKM BIOPARTS", it's likely a single store app for now.
        
        $store = Stores::first();
        
        if (!$store) {
            return view('front.no-store');
        }

        $query = Items::where('store_id', $store->id)
            ->where('quantity', '>', 0); // Only show in-stock items

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->with('category')->paginate(12);
        $categories = Categories::where('store_id', $store->id)->get();

        return view('front.catalog.index', compact('items', 'categories', 'store'));
    }

    public function show(Items $item)
    {
        return view('front.catalog.show', compact('item'));
    }
}
