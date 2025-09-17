<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Vendor;

class UserProductController extends Controller
{
    /**
     * Display a listing of products for users.
     */
    public function index(Request $request)
    {
        $query = Product::with(['vendor', 'category', 'status', 'reviews'])
            ->active()
            ->inStock();

        // Filter by category if specified
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by vendor if specified
        if ($request->has('vendor') && $request->vendor) {
            $query->byVendor($request->vendor);
        }

        // Search by name if specified
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort by price if specified
        if ($request->has('sort_by') && $request->sort_by) {
            switch ($request->sort_by) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->withCount('reviews')
                        ->orderBy('reviews_count', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        
        // Get categories and vendors for filters
        $categories = ProductCategory::orderBy('name')->get() ?? collect();
        $vendors = Vendor::orderBy('name')->get() ?? collect();

        return view('user_layouts.product', compact('products', 'categories', 'vendors'));
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with([
            'vendor', 
            'category', 
            'status', 
            'reviews.user', 
            'variants', 
            'tags'
        ])
        ->active()
        ->findOrFail($id);

        // Get related products from the same category
        $relatedProducts = Product::with(['vendor', 'category', 'status'])
            ->active()
            ->inStock()
            ->where('product_category_id', $product->category->id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        // Calculate average rating
        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $reviewCount = $product->reviews()->count();

        return view('user_layouts.product-detail', compact(
            'product', 
            'relatedProducts', 
            'averageRating', 
            'reviewCount'
        ));
    }

    /**
     * Get products by category.
     */
    public function byCategory($categoryId)
    {
        $category = ProductCategory::findOrFail($categoryId);
        
        $products = Product::with(['vendor', 'category', 'status', 'reviews'])
            ->active()
            ->inStock()
            ->byCategory($categoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ProductCategory::orderBy('name')->get() ?? collect();
        $vendors = Vendor::orderBy('name')->get() ?? collect();

        return view('user_layouts.product', compact(
            'products', 
            'categories', 
            'vendors', 
            'category'
        ));
    }

    /**
     * Get products by vendor.
     */
    public function byVendor($vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);
        
        $products = Product::with(['vendor', 'category', 'status', 'reviews'])
            ->active()
            ->inStock()
            ->byVendor($vendorId)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ProductCategory::orderBy('name')->get() ?? collect();
        $vendors = Vendor::orderBy('name')->get() ?? collect();

        return view('user_layouts.product', compact(
            'products', 
            'categories', 
            'vendors', 
            'vendor'
        ));
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('q');
        
        $products = Product::with(['vendor', 'category', 'status', 'reviews'])
            ->active()
            ->inStock()
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ProductCategory::orderBy('name')->get() ?? collect();
        $vendors = Vendor::orderBy('name')->get() ?? collect();

        return view('user_layouts.product', compact(
            'products', 
            'categories', 
            'vendors', 
            'searchTerm'
        ));
    }
}
