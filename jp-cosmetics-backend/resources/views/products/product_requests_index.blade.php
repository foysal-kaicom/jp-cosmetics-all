@extends('master')

@section('contents')

<style>
    .badge-pill { border-radius:999px; padding:.35rem .6rem; font-size:.75rem; }
    .badge-gray { background:#eef2f7; color:#334155; }
    .cardish { background:#fff; border-radius:10px; box-shadow:0 1px 8px rgba(16,24,40,.06); }
    select.form-select { max-width:220px; }
</style>

<section class="w-100 bg-white rounded overflow-hidden shadow">

    <!-- Header -->
    <div class="py-3 px-4 d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">

        <h3 class="text-md m-0">Product Requests</h3>

        <!-- Filter Dropdown -->
        {{-- <form action="{{ route('admin.product-requests.index') }}" method="GET"
              class="d-flex gap-2 align-items-center">

            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                @foreach(['pending','reviewed','approved','rejected'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <div class="col-6 col-md-2">
                <button class="btn btn-outline-light btn-sm">Filter</button>
            </div>

            <div class="col-6 col-md-2">
                <a href="{{ route('admin.product-requests.index') }}"
                   class="btn btn-outline-danger btn-sm">Reset</a>
            </div>
        </form> --}}
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Details</th>
                    {{-- <th>Status</th> --}}
                    <th>Requested On</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($request->customer)
                                <div class="fw-semibold">
                                    {{ $request->customer->name }}
                                </div>
                                <div class="text-muted small">
                                    {{ $request->customer->email }}
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td class="fw-semibold">{{ $request->name }}</td>

                        <td>
                            @if($request->image)
                                <img src="{{ $request->image }}"
                                     width="55"
                                     class="img-thumbnail">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>
                            <span title="{{ $request->details }}">
                                {{ Str::limit($request->details, 50, '...') ?? '—' }}
                            </span>
                        </td>



                        <td>
                            {{ $request->created_at?->format('d M, Y h:i A') ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No product requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($requests, 'links'))
        <div class="px-3 pb-3">
            {{ $requests->links() }}
        </div>
    @endif

</section>

@endsection
