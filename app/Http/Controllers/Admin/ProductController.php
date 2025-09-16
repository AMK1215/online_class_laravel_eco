<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductStatus;
use App\Models\Admin\Vendor;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['vendor', 'category', 'status'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::orderBy('name')->get();
        $categories = ProductCategory::orderBy('name')->get();
        $statuses = ProductStatus::orderBy('name')->get();
        
        return view('admin.product.create', compact('vendors', 'categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'product_status_id' => 'required|exists:product_statuses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['vendor', 'category', 'status', 'variants', 'reviews'])
            ->findOrFail($id);
            
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $vendors = Vendor::orderBy('name')->get();
        $categories = ProductCategory::orderBy('name')->get();
        $statuses = ProductStatus::orderBy('name')->get();
        
        return view('admin.product.edit', compact('product', 'vendors', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'product_status_id' => 'required|exists:product_statuses,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product status between Active and Inactive
     */
    public function toggleStatus(string $id)
    {
        $product = Product::findOrFail($id);
        $activeStatus = ProductStatus::where('name', 'Active')->first();
        $inactiveStatus = ProductStatus::where('name', 'Inactive')->first();
        
        if ($product->product_status_id == $activeStatus->id) {
            $product->update(['product_status_id' => $inactiveStatus->id]);
            $message = 'Product deactivated successfully!';
        } else {
            $product->update(['product_status_id' => $activeStatus->id]);
            $message = 'Product activated successfully!';
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Update product quantity
     */
    public function updateQuantity(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);
        
        $product = Product::findOrFail($id);
        $product->update(['quantity' => $request->quantity]);
        
        return redirect()->back()->with('success', 'Product quantity updated successfully!');
    }
}
