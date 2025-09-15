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
            <h5 class="mb-0">ProductCategory Dashboards</h5>

          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.product-categories.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Create Product Category</a>
              <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-flush" id="users-search">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Parent Category</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($productCategories as $index => $category)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $category->name }}</td>
              <td>
                @if($category->parent)
                  {{ $category->parent->name }}
                @else
                  <span class="badge bg-gradient-info">Main Category</span>
                @endif
              </td>
              <td>{{ $category->created_at->format('M d, Y') }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <a href="{{ route('admin.product-categories.show', $category->id) }}" class="btn btn-link btn-sm mb-0 px-0 ms-4" data-bs-toggle="tooltip" data-bs-placement="top" title="View Category">
                    <i class="fas fa-eye text-secondary"></i>
                  </a>
                  <a href="{{ route('admin.product-categories.edit', $category->id) }}" class="btn btn-link btn-sm mb-0 px-0 ms-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category">
                    <i class="fas fa-pencil-alt text-secondary"></i>
                  </a>
                  <form action="{{ route('admin.product-categories.destroy', $category->id) }}" method="POST" class="d-inline-block ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm mb-0 px-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category" onclick="return confirm('Are you sure you want to delete this category?')">
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
                  <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>
                  <h6 class="text-secondary">No product categories found</h6>
                  <p class="text-muted mb-0">Start by creating your first product category</p>
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
</script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection