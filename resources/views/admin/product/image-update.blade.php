@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Update Product Image</h5>
            <p class="text-sm mb-0">
              Update the image for "{{ $product->name }}".
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-outline-primary btn-sm mb-0 me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Product
              </a>
              <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm mb-0">
                <i class="fas fa-list me-1"></i> All Products
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <div class="row">
          <!-- Current Image Display -->
          <div class="col-md-4">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-info">
                <h6 class="text-white mb-0">
                  <i class="fas fa-image me-2"></i>Current Image
                </h6>
              </div>
              <div class="card-body text-center">
                @if($product->image)
                  <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                       class="img-fluid rounded mb-3" style="max-height: 300px;">
                  <div class="d-grid gap-2">
                    <form action="{{ route('admin.products.image-remove', $product->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to remove this image?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash me-1"></i> Remove Image
                      </button>
                    </form>
                  </div>
                @else
                  <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                       style="height: 300px;">
                    <div class="text-center">
                      <i class="fas fa-image fa-5x text-secondary mb-3"></i>
                      <p class="text-muted">No image uploaded</p>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Image Upload Form -->
          <div class="col-md-8">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-primary">
                <h6 class="text-white mb-0">
                  <i class="fas fa-upload me-2"></i>Upload New Image
                </h6>
              </div>
              <div class="card-body">
                <form action="{{ route('admin.products.image-update.update', $product->id) }}" 
                      method="POST" enctype="multipart/form-data" id="imageUploadForm">
                  @csrf
                  @method('PUT')
                  
                  <div class="form-group mb-4">
                    <label for="image" class="form-control-label">
                      <i class="fas fa-image me-1"></i>Select Image File
                    </label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           required>
                    @error('image')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                    <small class="form-text text-muted">
                      <i class="fas fa-info-circle me-1"></i>
                      Supported formats: JPEG, PNG, JPG, GIF, SVG. Maximum size: 2MB.
                    </small>
                  </div>

                  <!-- Image Preview -->
                  <div class="form-group mb-4" id="imagePreviewContainer" style="display: none;">
                    <label class="form-control-label">
                      <i class="fas fa-eye me-1"></i>Image Preview
                    </label>
                    <div class="text-center">
                      <img id="imagePreview" src="" alt="Preview" 
                           class="img-fluid rounded border" style="max-height: 200px;">
                    </div>
                  </div>

                  <!-- Product Information -->
                  <div class="alert alert-info">
                    <h6 class="alert-heading">
                      <i class="fas fa-info-circle me-1"></i>Product Information
                    </h6>
                    <div class="row">
                      <div class="col-sm-6">
                        <strong>Product Name:</strong><br>
                        <span class="text-primary">{{ $product->name }}</span>
                      </div>
                      <div class="col-sm-6">
                        <strong>Product ID:</strong><br>
                        <span class="text-muted">#{{ $product->id }}</span>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-sm-6">
                        <strong>Current Price:</strong><br>
                        <span class="text-success">${{ number_format($product->price, 2) }}</span>
                      </div>
                      <div class="col-sm-6">
                        <strong>Status:</strong><br>
                        @if($product->status->name === 'Active')
                          <span class="badge bg-gradient-success">{{ $product->status->name }}</span>
                        @else
                          <span class="badge bg-gradient-secondary">{{ $product->status->name }}</span>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.products.show', $product->id) }}" 
                       class="btn btn-outline-secondary">
                      <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn bg-gradient-primary" id="submitBtn">
                      <i class="fas fa-upload me-1"></i> Update Image
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Image Guidelines -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-warning">
                <h6 class="text-white mb-0">
                  <i class="fas fa-lightbulb me-2"></i>Image Guidelines
                </h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h6 class="text-primary">
                      <i class="fas fa-check-circle me-1"></i>Recommended
                    </h6>
                    <ul class="list-unstyled">
                      <li><i class="fas fa-check text-success me-2"></i>High resolution images (at least 800x600)</li>
                      <li><i class="fas fa-check text-success me-2"></i>Square aspect ratio (1:1) for best display</li>
                      <li><i class="fas fa-check text-success me-2"></i>Clear, well-lit product photos</li>
                      <li><i class="fas fa-check text-success me-2"></i>Minimal background or white background</li>
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <h6 class="text-danger">
                      <i class="fas fa-times-circle me-1"></i>Avoid
                    </h6>
                    <ul class="list-unstyled">
                      <li><i class="fas fa-times text-danger me-2"></i>Blurry or low-quality images</li>
                      <li><i class="fas fa-times text-danger me-2"></i>Images with text overlays</li>
                      <li><i class="fas fa-times text-danger me-2"></i>Inappropriate or offensive content</li>
                      <li><i class="fas fa-times text-danger me-2"></i>Images larger than 2MB</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('imageUploadForm');

    // Image preview functionality
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                imageInput.value = '';
                return;
            }
            
            // Validate file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                imageInput.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreviewContainer.style.display = 'none';
        }
    });

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Uploading...';
        submitBtn.disabled = true;
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
