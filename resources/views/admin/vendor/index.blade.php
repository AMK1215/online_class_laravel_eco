@extends('layouts.master')

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Vendor Management</h5>
            <p class="text-sm mb-0">Manage all vendors and their information</p>
          </div>
          <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">
              <a href="{{ route('admin.vendors.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Create Vendor</a>
              <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>
            </div>
          </div>
        </div>
      </div>

      <div>
        <!-- @php 
          $total_vendors = \App\Models\Admin\Vendor::count();
          $total_active_vendors = \App\Models\Admin\Vendor::where('status', true)->count();
          $total_inactive_vendors = \App\Models\Admin\Vendor::where('status', false)->count();

          $total_earnings = \App\Models\Admin\VendorPayment::sum('amount');
          $total_reviews = \App\Models\Admin\VendorReview::count();

          $average_rating = \App\Models\Admin\VendorReview::avg('rating');
          $average_commission_rate = \App\Models\Admin\Vendor::avg('commission_rate');

          echo "Total Vendors: " . $total_vendors . "<br>";
          echo "Total Active Vendors: " . $total_active_vendors . "<br>";
          echo "Total Inactive Vendors: " . $total_inactive_vendors . "<br>";
          echo "Total Earnings: " . $total_earnings . "<br>";
          echo "Total Reviews: " . $total_reviews . "<br>";
          echo "Average Rating: " . $average_rating . "<br>";
          echo "Average Commission Rate: " . $average_commission_rate . "<br>";
        @endphp -->
        </div>

        <div class="row">
          <div class="col-md-4">
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-flush" id="vendors-table">
          <thead class="thead-light">
            <th>#</th>
            <th>Vendor Name</th>
            <th>Contact Info</th>
            <th>Status</th>
            <th>Rating</th>
            <th>Total Earnings</th>
            <th>Commission Rate</th>
            <th>Actions</th>
          </thead>
          <tbody>
            @foreach ($vendors as $key => $vendor)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>
                <div class="d-flex px-2 py-1">
                  <div>
                    <h6 class="mb-0 text-sm">{{ $vendor->name }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ Str::limit($vendor->description, 50) }}</p>
                  </div>
                </div>
              </td>
              <td>
                <div class="text-sm">
                  @if($vendor->contact_email)
                    <div>{{ $vendor->contact_email }}</div>
                  @endif
                  @if($vendor->contact_phone)
                    <div>{{ $vendor->contact_phone }}</div>
                  @endif
                </div>
              </td>
              <td>
                <form action="{{ route('admin.vendors.toggle-status', $vendor->id) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm {{ $vendor->status ? 'btn-success' : 'btn-secondary' }}">
                    {{ $vendor->status ? 'Active' : 'Inactive' }}
                  </button>
                </form>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <span class="me-2 text-xs font-weight-bold">{{ number_format($vendor->average_rating, 1) }}</span>
                  <div>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="{{ $vendor->average_rating * 20 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $vendor->average_rating * 20 }}%"></div>
                    </div>
                  </div>
                </div>
                <span class="text-xs text-secondary">({{ $vendor->reviews_count }} reviews)</span>
              </td>
              <td>
                <span class="badge badge-sm bg-gradient-success">${{ number_format($vendor->total_earnings, 2) }}</span>
              </td>
              <td>
                @if($vendor->commission_rate)
                  <span class="text-sm">{{ $vendor->commission_rate }}%</span>
                @else
                  <span class="text-sm text-secondary">Not set</span>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('Delete this vendor?');" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
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
<script src="{{ asset('assets/js/plugins/datatables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
  if (document.getElementById('vendors-table')) {
    const dataTableSearch = new simpleDatatables.DataTable("#vendors-table", {
      searchable: true,
      fixedHeight: false,
      perPage: 10
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;
        var data = {
          type: type,
          filename: "vendors-" + type,
        };
        if (type === "csv") {
          data.columnDelimiter = "|";
        }
        dataTableSearch.export(data);
      });
    });
  }

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
</script>
@endsection