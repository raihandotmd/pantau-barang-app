<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Clickbar\Magellan\Data\Geometries\Point;

class StoreProfileController extends Controller
{
    public function edit()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            abort(404);
        }

        return view('store.profile.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores,slug,' . $store->id,
            'description' => 'nullable|string',
            'address' => 'required|string',
            'contact_info' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($store->banner_image) {
                Storage::disk('public')->delete($store->banner_image);
            }

            $path = $request->file('banner_image')->store('store-banners', 'public');
            $validated['banner_image'] = $path;
        }

        // Handle location
        $location = Point::make($validated['longitude'], $validated['latitude']);
        $validated['location'] = $location;
        unset($validated['latitude']);
        unset($validated['longitude']);

        // If store was rejected, reset status to pending for re-review
        if ($store->status === 'rejected') {
            $validated['status'] = 'pending';
        }

        $store->update($validated);

        return redirect()->route('store-profile.edit')->with('success', 'Profil toko berhasil diperbarui.');
    }
}
