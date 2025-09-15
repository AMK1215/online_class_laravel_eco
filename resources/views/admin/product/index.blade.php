@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Product Management</h5>
            <p class="text-sm mb-0">
              Manage your product inventory and catalog.
            </p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.products.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Add New Product</a>
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
        <table class="table table-flush" id="products-search">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Vendor</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Status</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $index => $product)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                @if($product->image)
                  <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                       class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                @else
                  <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                       style="width: 40px; height: 40px;">
                    <i class="fas fa-image text-white"></i>
                  </div>
                @endif
              </td>
              <td>
                <div>
                  <h6 class="mb-0">{{ $product->name }}</h6>
                  <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                </div>
              </td>
              <td>
                <span class="badge bg-gradient-info">{{ $product->category->name }}</span>
              </td>
              <td>{{ $product->vendor->name }}</td>
              <td>
                <span class="text-success font-weight-bold">${{ number_format($product->price, 2) }}</span>
              </td>
              <td>
                @if($product->quantity > 0)
                  <span class="badge bg-gradient-success">{{ $product->quantity }}</span>
                @else
                  <span class="badge bg-gradient-danger">Out of Stock</span>
                @endif
              </td>
              <td>
                @if($product->status->name === 'Active')
                  <span class="badge bg-gradient-success">{{ $product->status->name }}</span>
                @elseif($product->status->name === 'Inactive')
                  <span class="badge bg-gradient-secondary">{{ $product->status->name }}</span>
                @else
                  <span class="badge bg-gradient-info">{{ $product->status->name }}</span>
                @endif
              </td>
              <td>{{ $product->created_at->format('M d, Y') }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <a href="{{ route('admin.products.show', $product->id) }}" 
                     class="btn btn-link btn-sm mb-0 px-0 ms-4" 
                     data-bs-toggle="tooltip" data-bs-placement="top" title="View Product">
                    <i class="fas fa-eye text-secondary"></i>
                  </a>
                  <a href="{{ route('admin.products.edit', $product->id) }}" 
                     class="btn btn-link btn-sm mb-0 px-0 ms-4" 
                     data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Product">
                    <i class="fas fa-pencil-alt text-secondary"></i>
                  </a>
                  
                  <!-- Toggle Status Button -->
                  <form action="{{ route('admin.products.toggle-status', $product->id) }}" 
                        method="POST" class="d-inline-block ms-2">
                    @csrf
                    <button type="submit" class="btn btn-link btn-sm mb-0 px-0" 
                            data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="{{ $product->status->name === 'Active' ? 'Deactivate' : 'Activate' }}">
                      @if($product->status->name === 'Active')
                        <i class="fas fa-toggle-on text-success"></i>
                      @else
                        <i class="fas fa-toggle-off text-secondary"></i>
                      @endif
                    </button>
                  </form>
                  
                  <!-- Delete Button -->
                  <form action="{{ route('admin.products.destroy', $product->id) }}" 
                        method="POST" class="d-inline-block ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm mb-0 px-0" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Product" 
                            onclick="return confirm('Are you sure you want to delete this product?')">
                      <i class="fas fa-trash text-secondary"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center py-4">
                <div class="d-flex flex-column align-items-center">
                  <i class="fas fa-box fa-3x text-secondary mb-3"></i>
                  <h6 class="text-secondary">No products found</h6>
                  <p class="text-muted mb-0">Start by adding your first product</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      @if($products->hasPages())
      <div class="card-footer d-flex justify-content-center">
        {{ $products->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
  if (document.getElementById('products-search')) {
    const dataTableSearch = new simpleDatatables.DataTable("#products-search", {
      searchable: true,
      fixedHeight: false,
      perPage: 15
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "products-" + type,
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
