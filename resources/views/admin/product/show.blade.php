@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Product Details</h5>
            <p class="text-sm mb-0">
              View detailed information for "{{ $product->name }}".
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm mb-0 me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
              </a>
              <a href="{{ route('admin.products.edit', $product->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                <i class="fas fa-edit me-1"></i> Edit Product
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <div class="row">
          <!-- Product Image -->
          <div class="col-md-4">
            <div class="card border-0 shadow-sm">
              <div class="card-body text-center">
                @if($product->image)
                  <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                       class="img-fluid rounded" style="max-height: 300px;">
                @else
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                       style="height: 300px;">
                    <i class="fas fa-image fa-5x text-secondary"></i>
                  </div>
                @endif
                
                <!-- Quick Actions -->
                <div class="mt-3">
                  <div class="d-grid gap-2">
                    @if($product->status->name === 'Active')
                      <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                          <i class="fas fa-toggle-off me-1"></i> Deactivate
                        </button>
                      </form>
                    @else
                      <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success btn-sm">
                          <i class="fas fa-toggle-on me-1"></i> Activate
                        </button>
                      </form>
                    @endif
                    
                    <!-- Quick Quantity Update -->
                    <button type="button" class="btn btn-outline-info btn-sm" 
                            data-bs-toggle="modal" data-bs-target="#quantityModal">
                      <i class="fas fa-edit me-1"></i> Update Quantity
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Product Information -->
          <div class="col-md-8">
            <div class="row">
              <!-- Basic Information -->
              <div class="col-12">
                <div class="card border-0 shadow-sm mb-3">
                  <div class="card-header bg-gradient-primary">
                    <h6 class="text-white mb-0">
                      <i class="fas fa-info-circle me-2"></i>Basic Information
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-4">
                        <strong>Product Name:</strong>
                      </div>
                      <div class="col-sm-8">
                        <h5 class="mb-0">{{ $product->name }}</h5>
                      </div>
                    </div>
                    
                    <div class="row mt-3">
                      <div class="col-sm-4">
                        <strong>Product ID:</strong>
                      </div>
                      <div class="col-sm-8">
                        #{{ $product->id }}
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-sm-4">
                        <strong>Description:</strong>
                      </div>
                      <div class="col-sm-8">
                        <p class="mb-0">{{ $product->description }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pricing & Inventory -->
              <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-3">
                  <div class="card-header bg-gradient-success">
                    <h6 class="text-white mb-0">
                      <i class="fas fa-dollar-sign me-2"></i>Pricing & Inventory
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <strong>Price:</strong>
                      </div>
                      <div class="col-sm-6">
                        <span class="h5 text-success mb-0">${{ number_format($product->price, 2) }}</span>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <strong>Quantity:</strong>
                      </div>
                      <div class="col-sm-6">
                        @if($product->quantity > 0)
                          <span class="badge bg-gradient-success fs-6">{{ $product->quantity }}</span>
                        @else
                          <span class="badge bg-gradient-danger fs-6">Out of Stock</span>
                        @endif
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <strong>Status:</strong>
                      </div>
                      <div class="col-sm-6">
                        @if($product->status->name === 'Active')
                          <span class="badge bg-gradient-success">{{ $product->status->name }}</span>
                        @elseif($product->status->name === 'Inactive')
                          <span class="badge bg-gradient-secondary">{{ $product->status->name }}</span>
                        @else
                          <span class="badge bg-gradient-info">{{ $product->status->name }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Relationships -->
              <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-3">
                  <div class="card-header bg-gradient-info">
                    <h6 class="text-white mb-0">
                      <i class="fas fa-link me-2"></i>Relationships
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <strong>Vendor:</strong>
                      </div>
                      <div class="col-sm-6">
                        <a href="{{ route('admin.vendors.show', $product->vendor->id) }}" 
                           class="text-primary text-decoration-none">
                          {{ $product->vendor->name }}
                        </a>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <strong>Category:</strong>
                      </div>
                      <div class="col-sm-6">
                        <a href="{{ route('admin.product-categories.show', $product->category->id) }}" 
                           class="text-primary text-decoration-none">
                          {{ $product->category->name }}
                          @if($product->category->parent)
                            <br><small class="text-muted">({{ $product->category->parent->name }})</small>
                          @endif
                        </a>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6">
                        <strong>Created:</strong>
                      </div>
                      <div class="col-sm-6">
                        {{ $product->created_at->format('M d, Y \a\t h:i A') }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Additional Information -->
              <div class="col-12">
                <div class="card border-0 shadow-sm">
                  <div class="card-header bg-gradient-secondary">
                    <h6 class="text-white mb-0">
                      <i class="fas fa-clock me-2"></i>Additional Information
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <strong>Last Updated:</strong>
                        <p class="mb-0">{{ $product->updated_at->format('M d, Y \a\t h:i A') }}</p>
                      </div>
                      <div class="col-md-6">
                        <strong>Days Since Created:</strong>
                        <p class="mb-0">{{ $product->created_at->diffForHumans() }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex justify-content-end">
              <a href="{{ route('admin.products.edit', $product->id) }}" 
                 class="btn bg-gradient-primary me-2">
                <i class="fas fa-edit me-1"></i> Edit Product
              </a>
              
              <form action="{{ route('admin.products.destroy', $product->id) }}" 
                    method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Are you sure you want to delete this product?')">
                  <i class="fas fa-trash me-1"></i> Delete Product
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quantity Update Modal -->
<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quantityModalLabel">Update Product Quantity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.products.update-quantity', $product->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="quantity" class="form-control-label">New Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" 
                   value="{{ $product->quantity }}" min="0" required>
            <small class="form-text text-muted">Enter the new quantity for this product.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Quantity</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection
