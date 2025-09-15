@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Create New Vendor</h5>
            <p class="text-sm mb-0">Add a new vendor to the system</p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                <i class="fas fa-arrow-left me-2"></i>Back to Vendors
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <form method="POST" action="{{ route('admin.vendors.store') }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-building me-2 text-primary"></i>Vendor Name <span class="text-danger">*</span>
                </label>
                <div class="input-group input-group-outline">
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                         value="{{ old('name') }}" required 
                         placeholder="Enter vendor business name">
                </div>
                @error('name')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-user me-2 text-primary"></i>Associate User
                </label>
                <div class="input-group input-group-outline">
                  <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                    <option value="">Select User (Optional)</option>
                    @foreach($users as $user)
                      <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->user_name }})
                      </option>
                    @endforeach
                  </select>
                </div>
                @error('user_id')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-align-left me-2 text-primary"></i>Description <span class="text-danger">*</span>
                </label>
                <div class="input-group input-group-outline">
                  <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                            required placeholder="Describe the vendor's business, services, and expertise...">{{ old('description') }}</textarea>
                </div>
                @error('description')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-envelope me-2 text-primary"></i>Contact Email
                </label>
                <div class="input-group input-group-outline">
                  <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" 
                         value="{{ old('contact_email') }}" 
                         placeholder="vendor@example.com">
                </div>
                @error('contact_email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-phone me-2 text-primary"></i>Contact Phone
                </label>
                <div class="input-group input-group-outline">
                  <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" 
                         value="{{ old('contact_phone') }}" 
                         placeholder="+1 (555) 123-4567">
                </div>
                @error('contact_phone')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-map-marker-alt me-2 text-primary"></i>Address
                </label>
                <div class="input-group input-group-outline">
                  <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" 
                            placeholder="Enter complete business address...">{{ old('address') }}</textarea>
                </div>
                @error('address')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-percentage me-2 text-primary"></i>Commission Rate (%)
                </label>
                <div class="input-group input-group-outline">
                  <input type="number" name="commission_rate" step="0.01" min="0" max="100" 
                         class="form-control @error('commission_rate') is-invalid @enderror" 
                         value="{{ old('commission_rate') }}" 
                         placeholder="15.00">
                  <span class="input-group-text">%</span>
                </div>
                <small class="form-text text-muted">
                  <i class="fas fa-info-circle me-1"></i>Commission rate as a percentage (0-100)
                </small>
                @error('commission_rate')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">
                  <i class="fas fa-toggle-on me-2 text-primary"></i>Status
                </label>
                <div class="form-check form-switch ps-0">
                  <input class="form-check-input mt-1 ms-auto" type="checkbox" name="status" value="1" 
                         {{ old('status', true) ? 'checked' : '' }}>
                  <label class="form-check-label ms-3">Active</label>
                </div>
                <small class="form-text text-muted">
                  <i class="fas fa-info-circle me-1"></i>Active vendors can receive orders and payments
                </small>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" class="btn bg-gradient-primary">
                <i class="fas fa-save me-2"></i>Create Vendor
              </button>
              <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
/* Enhanced form styling */
.form-group {
  margin-bottom: 1.5rem;
}

.form-control-label {
  font-weight: 600;
  color: #344767;
  margin-bottom: 0.5rem;
  display: block;
}

.input-group-outline {
  position: relative;
  border-radius: 0.5rem;
  transition: all 0.2s ease;
}

.input-group-outline .form-control {
  border: 2px solid #e9ecef;
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  transition: all 0.2s ease;
  background-color: #fff;
}

.input-group-outline .form-control:focus {
  border-color: #5e72e4;
  box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
  background-color: #fff;
}

.input-group-outline .form-control::placeholder {
  color: #adb5bd;
  opacity: 1;
}

.input-group-outline .form-control:focus::placeholder {
  color: #6c757d;
}

.input-group-outline .form-control.is-invalid {
  border-color: #ea0606;
  box-shadow: 0 0 0 0.2rem rgba(234, 6, 6, 0.25);
}

.input-group-outline .form-control.is-valid {
  border-color: #2dce89;
  box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
}

.input-group-text {
  background-color: #f8f9fa;
  border: 2px solid #e9ecef;
  border-left: none;
  color: #6c757d;
  font-weight: 500;
}

.form-check-input {
  width: 3rem;
  height: 1.5rem;
  margin-top: 0.25rem;
  background-color: #e9ecef;
  border: 1px solid #dee2e6;
  border-radius: 1rem;
  transition: all 0.2s ease;
}

.form-check-input:checked {
  background-color: #5e72e4;
  border-color: #5e72e4;
}

.form-check-input:focus {
  box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
}

.form-text {
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

.invalid-feedback {
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

/* Button enhancements */
.btn {
  border-radius: 0.5rem;
  font-weight: 600;
  padding: 0.75rem 1.5rem;
  transition: all 0.2s ease;
}

.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Card enhancements */
.card {
  border: none;
  border-radius: 1rem;
  box-shadow: 0 0 2rem 0 rgba(136, 152, 170, 0.15);
}

.card-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 1rem 1rem 0 0 !important;
  border: none;
}

.card-header h5 {
  color: white;
  font-weight: 700;
}

.card-header p {
  color: rgba(255, 255, 255, 0.8);
}

/* Responsive improvements */
@media (max-width: 768px) {
  .form-group {
    margin-bottom: 1rem;
  }
  
  .btn {
    width: 100%;
    margin-bottom: 0.5rem;
  }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
  @if(session()->has('success'))
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 1500
    });
  @endif

  @if(session()->has('error'))
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      text: '{{ session('error') }}',
      showConfirmButton: false,
      timer: 1500
    });
  @endif

  // Add real-time validation feedback
  document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        if (this.value.trim() !== '') {
          this.classList.add('is-valid');
          this.classList.remove('is-invalid');
        } else if (this.hasAttribute('required')) {
          this.classList.add('is-invalid');
          this.classList.remove('is-valid');
        }
      });
      
      input.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
          this.classList.remove('is-invalid');
        }
      });
    });
  });
</script>
@endsection
