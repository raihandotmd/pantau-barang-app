<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Categories;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        $categories = Categories::where('store_id', Auth::user()->store_id)
            ->with('items')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        // Check if user has a store
        if (!Auth::user()->store_id) {
            return redirect()->route('store.create')->with('error', 'You need to create a store first.');
        }

        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Categories::create([
                'name' => $request->name,
                'store_id' => Auth::user()->store_id,
            ]);

            // Log activity
            $this->logActivity('category_created', "Created category: {$category->name}");

            return redirect()->route('dashboard')->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified category.
     */
    public function show(Categories $category)
    {
        // Check if category belongs to user's store
        if ($category->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Category not found.');
        }

        $category->load('items');

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Categories $category)
    {
        // Check if category belongs to user's store
        if ($category->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Category not found.');
        }

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Categories $category)
    {
        // Check if category belongs to user's store
        if ($category->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Category not found.');
        }

        try {
            $oldName = $category->name;
            $category->update([
                'name' => $request->name,
            ]);

            // Log activity
            $this->logActivity('category_updated', "Updated category: {$oldName} → {$request->name}");

            return redirect()->route('dashboard')->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Categories $category)
    {
        // Check if category belongs to user's store
        if ($category->store_id !== Auth::user()->store_id) {
            return redirect()->route('dashboard')->with('error', 'Category not found.');
        }

        // Check if category has items - use exists() instead of count() for performance
        if ($category->items()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Cannot delete category that has items.');
        }

        try {
            $categoryName = $category->name;
            $category->delete();

            // Log activity
            $this->logActivity('category_deleted', "Deleted category: {$categoryName}");

            return redirect()->route('dashboard')->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }
}