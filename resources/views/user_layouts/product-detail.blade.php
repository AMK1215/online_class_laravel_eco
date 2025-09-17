@extends('user_layouts.app')

@section('content')
<div class="container py-5">
    <!-- Product Details -->
    <div class="row gx-4 gx-lg-5">
        <!-- Product Image -->
        <div class="col-md-6">
            @if($product->image)
                <img class="card-img-top mb-5 mb-md-0" src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}" style="height: 400px; object-fit: cover;" />
            @else
                <div class="card-img-top mb-5 mb-md-0 bg-light d-flex align-items-center justify-content-center" 
                     style="height: 400px;">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="col-md-6">
            <div class="small mb-1">{{ $product->category->name }}</div>
            <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
            
            <!-- Reviews -->
            @if($reviewCount > 0)
                <div class="d-flex small text-warning mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $averageRating)
                            <div class="bi-star-fill"></div>
                        @else
                            <div class="bi-star"></div>
                        @endif
                    @endfor
                    <span class="text-muted ms-2">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                </div>
            @endif
            
            <!-- Price -->
            <div class="fs-5 mb-3">
                <span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span>
            </div>
            
            <!-- Stock Status -->
            @if($product->quantity > 0)
                <div class="text-success mb-3">
                    <i class="bi bi-check-circle"></i> In Stock ({{ $product->quantity }} available)
                </div>
            @else
                <div class="text-danger mb-3">
                    <i class="bi bi-x-circle"></i> Out of Stock
                </div>
            @endif
            
            <!-- Description -->
            <p class="lead">{{ $product->description }}</p>
            
            <!-- Vendor Info -->
            <div class="mb-3">
                <strong>Vendor:</strong> 
                <a href="{{ route('products.by-vendor', $product->vendor->id) }}" class="text-decoration-none">
                    {{ $product->vendor->name }}
                </a>
            </div>
            
            <!-- Product Variants -->
            @if($product->variants->count() > 0)
                <div class="mb-3">
                    <h6>Available Options:</h6>
                    @foreach($product->variants as $variant)
                        <div class="badge bg-secondary me-1 mb-1">
                            {{ $variant->variant_name }}: {{ $variant->variant_value }}
                            @if($variant->price_adjustment != 0)
                                ({{ $variant->price_adjustment > 0 ? '+' : '' }}${{ number_format($variant->price_adjustment, 2) }})
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            
            <!-- Product Tags -->
            @if($product->tags->count() > 0)
                <div class="mb-3">
                    <h6>Tags:</h6>
                    @foreach($product->tags as $tag)
                        <span class="badge bg-primary me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
            
            <!-- Actions -->
            <div class="d-flex">
                @if($product->quantity > 0)
                    <button class="btn btn-outline-dark flex-shrink-0" type="button">
                        <i class="bi-cart-fill me-1"></i>
                        Add to cart
                    </button>
                @else
                    <button class="btn btn-outline-secondary flex-shrink-0" type="button" disabled>
                        <i class="bi-cart-x me-1"></i>
                        Out of Stock
                    </button>
                @endif
                
                <button class="btn btn-outline-primary ms-2" type="button">
                    <i class="bi-heart me-1"></i>
                    Add to Wishlist
                </button>
            </div>
        </div>
    </div>
    
    <!-- Product Reviews Section -->
    @if($product->reviews->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3>Customer Reviews</h3>
                <hr>
                @foreach($product->reviews->take(5) as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="card-title">{{ $review->user->name }}</h6>
                                    <div class="d-flex small text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <div class="bi-star-fill"></div>
                                            @else
                                                <div class="bi-star"></div>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="card-text">{{ $review->review }}</p>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($product->reviews->count() > 5)
                    <div class="text-center">
                        <button class="btn btn-outline-primary" onclick="loadMoreReviews()">
                            Load More Reviews
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3>Related Products</h3>
                <hr>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col mb-5">
                    <div class="card h-100">
                        @if($relatedProduct->quantity <= 5 && $relatedProduct->quantity > 0)
                            <div class="badge bg-warning text-dark position-absolute" style="top: 0.5rem; right: 0.5rem">
                                Low Stock
                            </div>
                        @elseif($relatedProduct->quantity == 0)
                            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                                Out of Stock
                            </div>
                        @endif
                        
                        @if($relatedProduct->image)
                            <img class="card-img-top" src="{{ Storage::url($relatedProduct->image) }}" 
                                 alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;" />
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">{{ $relatedProduct->name }}</h5>
                                <span class="h5 text-success">${{ number_format($relatedProduct->price, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $relatedProduct->id) }}">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function loadMoreReviews() {
    // Implement AJAX loading for more reviews
    console.log('Loading more reviews...');
}
</script>
@endsection
