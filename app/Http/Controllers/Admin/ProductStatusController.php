<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProductStatus;

class ProductStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productStatuses = ProductStatus::orderBy('name')->get();
        return view('admin.product_status.index', compact('productStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product_status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_statuses,name'
        ]);

        ProductStatus::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.product-statuses.index')
            ->with('success', 'Product status created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = ProductStatus::findOrFail($id);
        return view('admin.product_status.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = ProductStatus::findOrFail($id);
        return view('admin.product_status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $status = ProductStatus::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:product_statuses,name,' . $id
        ]);

        $status->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.product-statuses.index')
            ->with('success', 'Product status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = ProductStatus::findOrFail($id);
        
        // You can add additional checks here if products are using this status
        // For example: if ($status->products()->count() > 0) { ... }
        
        $status->delete();

        return redirect()->route('admin.product-statuses.index')
            ->with('success', 'Product status deleted successfully!');
    }
}
