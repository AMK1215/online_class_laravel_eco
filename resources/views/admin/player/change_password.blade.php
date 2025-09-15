@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Change Player Password</h5>
            <p class="text-sm mb-0">Player: {{ $player->name }} ({{ $player->user_name }})</p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.players.index') }}" class="btn btn-outline-primary btn-sm mb-0">Back to Players</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card-body">
        <form method="POST" action="{{ route('admin.players.makechange-password', $player->id) }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Player ID</label>
                <input type="text" class="form-control" value="{{ $player->user_name }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Player Name</label>
                <input type="text" class="form-control" value="{{ $player->name }}" readonly>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">New Password <span class="text-danger">*</span></label>
                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Password must be at least 6 characters long.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="text" name="password_confirmation" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" class="btn bg-gradient-primary">Change Password</button>
              <a href="{{ route('admin.players.index') }}" class="btn btn-secondary">Cancel</a>
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