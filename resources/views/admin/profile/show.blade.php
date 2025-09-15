@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">My Profile</h5>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.profile.edit') }}" class="btn bg-gradient-primary btn-sm mb-0">Edit Profile</a>
              <a href="{{ route('admin.profile.change-password') }}" class="btn btn-outline-primary btn-sm mb-0 mt-sm-0 mt-1">Change Password</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">User ID</label>
              <input type="text" class="form-control" value="{{ $user->user_name }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Name</label>
              <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Phone</label>
              <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Email</label>
              <input type="email" class="form-control" value="{{ $user->email ?? 'Not provided' }}" readonly>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Status</label>
              <div>
                @if ($user->status == 1)
                  <span class="badge badge-sm bg-gradient-success">Active</span>
                @else
                  <span class="badge badge-sm bg-gradient-danger">Inactive</span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">User Type</label>
              <input type="text" class="form-control" value="{{ ucfirst($user->type) }}" readonly>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Balance</label>
              <input type="text" class="form-control" value="{{ number_format($user->balance, 2) }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Max Score</label>
              <input type="text" class="form-control" value="{{ number_format($user->max_score, 2) }}" readonly>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Member Since</label>
              <input type="text" class="form-control" value="{{ $user->created_at->format('F j, Y') }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Last Updated</label>
              <input type="text" class="form-control" value="{{ $user->updated_at->format('F j, Y H:i') }}" readonly>
            </div>
          </div>
        </div>
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
