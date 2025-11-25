<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Clickbar\Magellan\Data\Geometries\Point;

class StoreController extends Controller
{
    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        // Check if user already has a store
        if (Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'You already have a store.');
        }

        return view('store.create');
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        // Check if user already has a store
        if (Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'You already have a store.');
        }

        try {
            DB::beginTransaction();

            // Create the store
            $store = Stores::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'contact_info' => $request->contact_info,
                'address' => $request->address,
                'description' => $request->description,
                'location' => Point::make($request->longitude, $request->latitude),
                'status' => 'pending',
            ]);

            // Update user's store_id
            Auth::user()->update([
                'store_id' => $store->id,
            ]);

            DB::commit();

            return redirect()->route('store.pending')->with('success', 'Toko berhasil dibuat! Mohon tunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to create store. Please try again.');
        }
    }

    /**
     * Generate a unique slug from the given name.
     */
    public function generateSlug(Request $request)
    {
        $name = $request->input('name');
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Ensure slug is unique
        while (Stores::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
        }
        
        return response()->json(['slug' => $slug]);
    }

    /**
     * Show the pending approval page.
     */
    public function pending()
    {
        return view('store.pending');
    }
}
