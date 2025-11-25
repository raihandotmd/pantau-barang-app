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
        $store = Stores::where('slug', $slug)->firstOrFail();
        
        $items = Items::where('store_id', $store->id)
            ->where('quantity', '>', 0)
            ->latest()
            ->get();

        return view('welcome', compact('store', 'items'));
    }

    public function profile($slug)
    {
        $store = Stores::where('slug', $slug)->firstOrFail();
        return view('front.store-profile', compact('store'));
    }
}
