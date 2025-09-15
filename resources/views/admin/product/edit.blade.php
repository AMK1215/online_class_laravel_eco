@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Edit Product</h5>
            <p class="text-sm mb-0">
              Update the details of "{{ $product->name }}".
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="row">
            <!-- Product Name -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-control-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $product->name) }}" 
                       placeholder="Enter product name" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <!-- Vendor -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="vendor_id" class="form-control-label">Vendor <span class="text-danger">*</span></label>
                <select class="form-control @error('vendor_id') is-invalid @enderror" 
                        id="vendor_id" name="vendor_id" required>
                  <option value="">-- Select Vendor --</option>
                  @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" 
                            {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>
                      {{ $vendor->name }}
                    </option>
                  @endforeach
                </select>
                @error('vendor_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Category -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="product_category_id" class="form-control-label">Category <span class="text-danger">*</span></label>
                <select class="form-control @error('product_category_id') is-invalid @enderror" 
                        id="product_category_id" name="product_category_id" required>
                  <option value="">-- Select Category --</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                      @if($category->parent)
                        ({{ $category->parent->name }})
                      @endif
                    </option>
                  @endforeach
                </select>
                @error('product_category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <!-- Status -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="product_status_id" class="form-control-label">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('product_status_id') is-invalid @enderror" 
                        id="product_status_id" name="product_status_id" required>
                  <option value="">-- Select Status --</option>
                  @foreach($statuses as $status)
                    <option value="{{ $status->id }}" 
                            {{ old('product_status_id', $product->product_status_id) == $status->id ? 'selected' : '' }}>
                      {{ $status->name }}
                    </option>
                  @endforeach
                </select>
                @error('product_status_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Price -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="price" class="form-control-label">Price <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control @error('price') is-invalid @enderror" 
                         id="price" name="price" value="{{ old('price', $product->price) }}" 
                         placeholder="0.00" step="0.01" min="0" required>
                </div>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <!-- Quantity -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="quantity" class="form-control-label">Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                       id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" 
                       placeholder="0" min="0" required>
                @error('quantity')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="description" class="form-control-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" 
                          placeholder="Enter detailed product description" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  Provide a detailed description of the product features, specifications, and benefits.
                </small>
              </div>
            </div>
          </div>

          <!-- Image Upload -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="image" class="form-control-label">Product Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  Upload a new product image (JPEG, PNG, JPG, GIF). Max size: 2MB. Leave empty to keep current image.
                </small>
              </div>
            </div>
            
            <!-- Current Image & Preview -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Current Image</label>
                <div id="current-image" class="border rounded p-3 text-center" style="min-height: 120px;">
                  @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                         class="img-fluid" style="max-height: 100px;">
                    <p class="text-muted mt-2 mb-0">Current image</p>
                  @else
                    <i class="fas fa-image fa-3x text-secondary"></i>
                    <p class="text-muted mt-2 mb-0">No image</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Product Information -->
          <div class="row mt-3">
            <div class="col-12">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="text-muted mb-2">Product Information</h6>
                  <div class="row">
                    <div class="col-md-3">
                      <small class="text-muted">Product ID:</small>
                      <p class="mb-0">#{{ $product->id }}</p>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted">Created:</small>
                      <p class="mb-0">{{ $product->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted">Last Updated:</small>
                      <p class="mb-0">{{ $product->updated_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted">Current Status:</small>
                      <p class="mb-0">
                        @if($product->status->name === 'Active')
                          <span class="badge bg-gradient-success">{{ $product->status->name }}</span>
                        @else
                          <span class="badge bg-gradient-secondary">{{ $product->status->name }}</span>
                        @endif
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="d-flex justify-content-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn bg-gradient-primary">
                  <i class="fas fa-save me-1"></i> Update Product
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Image preview functionality
  document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const currentImage = document.getElementById('current-image');
    
    imageInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          currentImage.innerHTML = `
            <img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 100px;">
            <p class="text-muted mt-2 mb-0">New image preview</p>
          `;
        };
        reader.readAsDataURL(file);
      } else {
        // Reset to current image
        @if($product->image)
          currentImage.innerHTML = `
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                 class="img-fluid" style="max-height: 100px;">
            <p class="text-muted mt-2 mb-0">Current image</p>
          `;
        @else
          currentImage.innerHTML = `
            <i class="fas fa-image fa-3x text-secondary"></i>
            <p class="text-muted mt-2 mb-0">No image</p>
          `;
        @endif
      }
    });
    
    // Form validation feedback
    const form = document.querySelector('form');
    const requiredInputs = form.querySelectorAll('[required]');
    
    requiredInputs.forEach(input => {
      input.addEventListener('input', function() {
        if (this.value.length > 0) {
          this.classList.remove('is-invalid');
          this.classList.add('is-valid');
        }
      });
    });
  });
</script>
@endsection
