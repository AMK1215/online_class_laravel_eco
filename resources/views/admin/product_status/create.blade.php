@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Create Product Status</h5>
            <p class="text-sm mb-0">
              Add a new product status to organize your inventory.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-statuses.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                <i class="fas fa-arrow-left me-1"></i> Back to Statuses
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

        <form action="{{ route('admin.product-statuses.store') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name" class="form-control-label">Status Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Enter status name (e.g., Active, Inactive, Draft)" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                  Choose a descriptive name for the product status (e.g., "Active", "Out of Stock", "Featured")
                </small>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="d-flex justify-content-end">
                <a href="{{ route('admin.product-statuses.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn bg-gradient-primary">
                  <i class="fas fa-save me-1"></i> Create Status
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
