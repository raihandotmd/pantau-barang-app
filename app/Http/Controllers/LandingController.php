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
        // Fetch        $stores = Stores::where('status', 'active')->get();
        $stores = Stores::orderBy('name')->get();

        return view('landing', compact('stores'));
    }
}
