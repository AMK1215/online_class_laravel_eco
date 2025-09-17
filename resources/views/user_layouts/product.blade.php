@extends('user_layouts.master')

@push('styles')
<style>
.pagination-container .pagination {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
    overflow: hidden;
}

.pagination-container .page-link {
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.pagination-container .page-link:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    color: #495057;
    transform: translateY(-1px);
}

.pagination-container .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    font-weight: 600;
}

.pagination-container .page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #adb5bd;
}

.pagination-container .page-item:first-child .page-link {
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem;
}

.pagination-container .page-item:last-child .page-link {
    border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
}

@media (max-width: 576px) {
    .pagination-container .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@section('content')
<!-- Filters Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search Products</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @isset($categories)
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <select class="form-select" id="vendor" name="vendor">
                            <option value="">All Vendors</option>
                            @isset($vendors)
                                @foreach($vendors as $v)
                                    <option value="{{ $v->id }}" {{ request('vendor') == $v->id ? 'selected' : '' }}>
                                        {{ $v->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="sort_by" class="form-label">Sort By</label>
                        <select class="form-select" id="sort_by" name="sort_by">
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Filter Products</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear Filters</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @isset($products)
        @forelse($products as $product)
        <div class="col mb-5">
            <div class="card h-100">
                @if($product->quantity <= 5 && $product->quantity > 0)
                    <!-- Low stock badge -->
                    <div class="badge bg-warning text-dark position-absolute" style="top: 0.5rem; right: 0.5rem">
                        Low Stock
                    </div>
                @elseif($product->quantity == 0)
                    <!-- Out of stock badge -->
                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                        Out of Stock
                    </div>
                @endif
                
                <!-- Product image -->
                @if($product->image)
                    <img class="card-img-top" src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}" style="height: 200px; object-fit: cover;" />
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                
                <!-- Product details -->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name -->
                        <h5 class="fw-bolder">{{ $product->name }}</h5>
                        
                        <!-- Product category -->
                        <small class="text-muted mb-2 d-block">{{ $product->category->name }}</small>
                        
                        <!-- Product reviews -->
                        @if($product->reviews_count > 0)
                            @php
                                $averageRating = $product->reviews()->avg('rating') ?? 0;
                            @endphp
                            <div class="d-flex justify-content-center small text-warning mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $averageRating)
                                        <div class="bi-star-fill"></div>
                                    @else
                                        <div class="bi-star"></div>
                                    @endif
                                @endfor
                                <span class="text-muted ms-1">({{ $product->reviews_count }})</span>
                            </div>
                        @endif
                        
                        <!-- Product price -->
                        <span class="h5 text-success">${{ number_format($product->price, 2) }}</span>
                        
                        <!-- Stock status -->
                        @if($product->quantity > 0)
                            <div class="small text-success mt-1">
                                <i class="bi bi-check-circle"></i> In Stock ({{ $product->quantity }})
                            </div>
                        @else
                            <div class="small text-danger mt-1">
                                <i class="bi bi-x-circle"></i> Out of Stock
                            </div>
                        @endif
                        
                        <!-- Vendor info -->
                        <div class="small text-muted mt-2">
                            by {{ $product->vendor->name }}
                        </div>
                    </div>
                </div>
                
                <!-- Product actions -->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $product->id) }}">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">No Products Found</h4>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'category', 'vendor']))
                                Try adjusting your filters or search terms.
                            @else
                                No products are currently available.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'category', 'vendor']))
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                View All Products
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforelse
    @else
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Unable to Load Products</h4>
                    <p class="text-muted">There was an issue loading the product data.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Refresh Page</a>
                </div>
            </div>
        </div>
    @endisset
</div>

<!-- Pagination -->
@isset($products)
    @if($products->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="pagination-container w-100" style="max-width: 800px;">
                        {{ $products->appends(request()->query())->links('custom-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endisset
@endsection