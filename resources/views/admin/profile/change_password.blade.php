@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Change Password</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-primary btn-sm mb-0">Back to Profile</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.update-password') }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Current Password <span class="text-danger">*</span></label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">New Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Password must be at least 6 characters long.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Confirm New Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" class="btn bg-gradient-primary">Change Password</button>
              <a href="{{ route('admin.profile.show') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
</script>
@endsection
