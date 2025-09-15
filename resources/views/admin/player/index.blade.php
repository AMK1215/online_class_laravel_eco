@extends('layouts.master')
@section('styles')
<style>
  .transparent-btn {
    background: none;
    border: none;
    padding: 0;
    outline: none;
    cursor: pointer;
    box-shadow: none;
    appearance: none;
    /* For some browsers */
  }
</style>
@endsection
@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Player Dashboards</h5>

          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.players.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Create Player</a>
              <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-flush" id="users-search">
          <thead class="thead-light">
            <th>#</th>
            <th>PlayerID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Status</th>
            
            <th>Action</th>
           
          </thead>
          <tbody>
            @foreach ($players as $key => $player)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $player->user_name }}</td>
              <td>{{ $player->name }}</td>
              <td>{{ $player->phone }}</td>
              <td>
                <form action="{{ route('admin.players.toggle-status', $player->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm {{ $player->status ? 'btn-success' : 'btn-secondary' }}">
                    {{ $player->status ? 'Active' : 'Inactive' }}
                  </button>
                </form>
              </td>
              <td>
                <a href="{{ route('admin.players.edit', $player->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <a href="{{ route('admin.players.show', $player->id) }}" class="btn btn-info btn-sm">Show</a>
                <form action="{{ route('admin.players.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Delete this player?');" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
                <!-- <form action="{{ route('admin.players.reset-password', $player->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-warning btn-sm">Reset Password</button>
                </form> -->

                <a href="{{ route('admin.players.change-password', $player->id) }}" class="btn btn-warning btn-sm">Change Password</a>
              </td>
            </tr>
            @endforeach
          </tbody>
         
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

{{-- <script>
    const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
      searchable: true,
      fixedHeight: true
    });
  </script> --}}
<script>
  if (document.getElementById('users-search')) {
    const dataTableSearch = new simpleDatatables.DataTable("#users-search", {
      searchable: true,
      fixedHeight: false,
      perPage: 7
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "material-" + type,
        };

        if (type === "csv") {
          data.columnDelimiter = "|";
        }

        dataTableSearch.export(data);
      });
    });
  };
  @if(session()->has('password_reset_user_name'))
    Swal.fire({
      icon: 'success',
      title: 'Password Reset',
      html: `
        <div class="text-start">
          <div><strong>User:</strong> {{ session('password_reset_user_name') }}</div>
          <div><strong>New Password:</strong> {{ session('password_reset_password') }}</div>
        </div>
      `
    });
  @endif
</script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection