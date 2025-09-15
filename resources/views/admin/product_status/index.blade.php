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
            <h5 class="mb-0">Product Status Dashboard</h5>
            <p class="text-sm mb-0">
              Manage product statuses for your inventory system.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-statuses.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Create Product Status</a>
              <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>
            </div>
          </div>
        </div>
      </div>
      
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
            check
          </span>
        </span>
        <span class="alert-text"><strong>Success!</strong> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert">
        <span class="alert-icon align-middle">
          <span class="material-icons text-md">
            error
          </span>
        </span>
        <span class="alert-text"><strong>Error!</strong> {{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

      <div class="table-responsive">
        <table class="table table-flush" id="statuses-search">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Status Name</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($productStatuses as $index => $status)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <span class="badge bg-gradient-primary">{{ $status->name }}</span>
              </td>
              <td>{{ $status->created_at->format('M d, Y') }}</td>
              <td>{{ $status->updated_at->format('M d, Y') }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <a href="{{ route('admin.product-statuses.show', $status->id) }}" class="btn btn-link btn-sm mb-0 px-0 ms-4" data-bs-toggle="tooltip" data-bs-placement="top" title="View Status">
                    <i class="fas fa-eye text-secondary"></i>
                  </a>
                  <a href="{{ route('admin.product-statuses.edit', $status->id) }}" class="btn btn-link btn-sm mb-0 px-0 ms-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Status">
                    <i class="fas fa-pencil-alt text-secondary"></i>
                  </a>
                  <form action="{{ route('admin.product-statuses.destroy', $status->id) }}" method="POST" class="d-inline-block ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm mb-0 px-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Status" onclick="return confirm('Are you sure you want to delete this status?')">
                      <i class="fas fa-trash text-secondary"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4">
                <div class="d-flex flex-column align-items-center">
                  <i class="fas fa-tag fa-3x text-secondary mb-3"></i>
                  <h6 class="text-secondary">No product statuses found</h6>
                  <p class="text-muted mb-0">Start by creating your first product status</p>
                </div>
              </td>
            </tr>
            @endforelse
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

<script>
  if (document.getElementById('statuses-search')) {
    const dataTableSearch = new simpleDatatables.DataTable("#statuses-search", {
      searchable: true,
      fixedHeight: false,
      perPage: 7
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "product-statuses-" + type,
        };

        if (type === "csv") {
          data.columnDelimiter = "|";
        }

        dataTableSearch.export(data);
      });
    });
  };
</script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection
