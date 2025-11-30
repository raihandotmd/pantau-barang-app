<?php

namespace App\Http\Controllers;

use App\Models\Stores;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page with list of stores.
     */
    public function index()
    {
        // Fetch all stores, ordered by name
        // You might want to filter by 'status' => 'approved' if you have that column
        $stores = Stores::orderBy('name')->get();

        return view('landing', compact('stores'));
    }
}
