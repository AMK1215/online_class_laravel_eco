@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Product Status Details</h5>
            <p class="text-sm mb-0">
              View details for "{{ $status->name }}" status.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-statuses.index') }}" class="btn btn-outline-primary btn-sm mb-0 me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Statuses
              </a>
              <a href="{{ route('admin.product-statuses.edit', $status->id) }}" class="btn bg-gradient-primary btn-sm mb-0">
                <i class="fas fa-edit me-1"></i> Edit Status
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <div class="row">
          <!-- Status Information -->
          <div class="col-md-8">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-primary">
                <h6 class="text-white mb-0">
                  <i class="fas fa-tag me-2"></i>Status Information
                </h6>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Status Name:</strong>
                  </div>
                  <div class="col-sm-8">
                    <span class="badge bg-gradient-primary fs-6 px-3 py-2">{{ $status->name }}</span>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Status ID:</strong>
                  </div>
                  <div class="col-sm-8">
                    #{{ $status->id }}
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Created:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $status->created_at->format('M d, Y \a\t h:i A') }}
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Last Updated:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $status->updated_at->format('M d, Y \a\t h:i A') }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Usage Statistics (Placeholder for future development) -->
          <div class="col-md-4">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-gradient-info">
                <h6 class="text-white mb-0">
                  <i class="fas fa-chart-bar me-2"></i>Usage Statistics
                </h6>
              </div>
              <div class="card-body">
                <div class="text-center py-4">
                  <i class="fas fa-chart-line fa-3x text-secondary mb-3"></i>
                  <h6 class="text-secondary">Coming Soon</h6>
                  <p class="text-muted mb-0 small">
                    Product usage statistics will be available when the product system is implemented.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex justify-content-end">
              <a href="{{ route('admin.product-statuses.edit', $status->id) }}" 
                 class="btn bg-gradient-primary me-2">
                <i class="fas fa-edit me-1"></i> Edit Status
              </a>
              
              <form action="{{ route('admin.product-statuses.destroy', $status->id) }}" 
                    method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Are you sure you want to delete this status?')">
                  <i class="fas fa-trash me-1"></i> Delete Status
                </button>
              </form>
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
