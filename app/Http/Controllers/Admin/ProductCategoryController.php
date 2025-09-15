<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::with('parent')->orderBy('name')->get();
        return view('admin.product_category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.product_category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'parent_id' => 'nullable|exists:product_categories,id'
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = ProductCategory::with(['parent', 'children'])->findOrFail($id);
        return view('admin.product_category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = ProductCategory::findOrFail($id);
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get();
        return view('admin.product_category.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $id,
            'parent_id' => 'nullable|exists:product_categories,id'
        ]);

        // Prevent setting itself as parent or creating circular reference
        if ($request->parent_id == $id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = ProductCategory::findOrFail($id);
        
        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.product-category.index')
                ->with('error', 'Cannot delete category with subcategories. Please delete subcategories first.');
        }

        $category->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully!');
    }
}
