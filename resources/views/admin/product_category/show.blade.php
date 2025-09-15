@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Product Category Details</h5>
            <p class="text-sm mb-0">
              View details for "{{ $category->name }}" category.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-primary btn-sm mb-0 me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
              </a>
              <a href="{{ route('admin.product-category.edit', $category->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                <i class="fas fa-edit me-1"></i> Edit Category
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <div class="row">
          <!-- Category Information -->
          <div class="col-md-6">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-primary">
                <h6 class="text-white mb-0">
                  <i class="fas fa-tag me-2"></i>Category Information
                </h6>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Category Name:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $category->name }}
                  </div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Category Type:</strong>
                  </div>
                  <div class="col-sm-8">
                    @if($category->parent)
                      <span class="badge bg-gradient-info">Subcategory</span>
                    @else
                      <span class="badge bg-gradient-success">Main Category</span>
                    @endif
                  </div>
                </div>

                @if($category->parent)
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Parent Category:</strong>
                  </div>
                  <div class="col-sm-8">
                    <a href="{{ route('admin.product-category.show', $category->parent->id) }}" 
                       class="text-primary text-decoration-none">
                      {{ $category->parent->name }}
                    </a>
                  </div>
                </div>
                @endif

                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Created:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $category->created_at->format('M d, Y \a\t h:i A') }}
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Last Updated:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $category->updated_at->format('M d, Y \a\t h:i A') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Subcategories -->
          <div class="col-md-6">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-info">
                <h6 class="text-white mb-0">
                  <i class="fas fa-sitemap me-2"></i>Subcategories ({{ $category->children->count() }})
                </h6>
              </div>
              <div class="card-body">
                @if($category->children->count() > 0)
                  <div class="list-group list-group-flush">
                    @foreach($category->children as $child)
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                      <div>
                        <i class="fas fa-tag text-secondary me-2"></i>
                        {{ $child->name }}
                      </div>
                      <div>
                        <a href="{{ route('admin.product-category.show', $child->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.product-category.edit', $child->id) }}" 
                           class="btn btn-sm btn-outline-secondary ms-1">
                          <i class="fas fa-edit"></i>
                        </a>
                      </div>
                    </div>
                    @endforeach
                  </div>
                @else
                  <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>
                    <h6 class="text-secondary">No subcategories found</h6>
                    <p class="text-muted mb-0">This category doesn't have any subcategories yet.</p>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex justify-content-end">
              <a href="{{ route('admin.product-categories.edit', $category->id) }}" 
                 class="btn bg-gradient-primary me-2">
                <i class="fas fa-edit me-1"></i> Edit Category
              </a>
              
              @if($category->children->count() == 0)
              <form action="{{ route('admin.product-categories.destroy', $category->id) }}" 
                    method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Are you sure you want to delete this category?')">
                  <i class="fas fa-trash me-1"></i> Delete Category
                </button>
              </form>
              @else
              <button type="button" class="btn btn-outline-secondary" disabled 
                      data-bs-toggle="tooltip" data-bs-placement="top" 
                      title="Cannot delete category with subcategories">
                <i class="fas fa-trash me-1"></i> Delete Category
              </button>
              @endif
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
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection
