@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Create Product Category</h5>
            <p class="text-sm mb-0">
              Add a new product category to organize your products.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
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

        <form action="{{ route('admin.product-categories.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="form-control-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Enter category name" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="parent_id" class="form-control-label">Parent Category</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" 
                        id="parent_id" name="parent_id">
                  <option value="">-- Select Parent Category (Optional) --</option>
                  @foreach($parentCategories as $parentCategory)
                    <option value="{{ $parentCategory->id }}" 
                            {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                      {{ $parentCategory->name }}
                    </option>
                  @endforeach
                </select>
                @error('parent_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  Leave empty to create a main category, or select a parent to create a subcategory.
                </small>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="d-flex justify-content-end">
                <a href="{{ route('admin.product-categories.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn bg-gradient-primary">
                  <i class="fas fa-save me-1"></i> Create Category
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
  // Form validation feedback
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    
    nameInput.addEventListener('input', function() {
      if (this.value.length > 0) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
      }
    });
  });
</script>
@endsection
