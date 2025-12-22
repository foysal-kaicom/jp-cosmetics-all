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
        <h3 class="text-md m-0">Wishlist</h3>

        <!-- Filter Dropdown -->
        <form action="{{ route('wishlist.list') }}" method="GET" class="d-flex gap-2 align-items-center">
            <select name="product_id" class="form-select form-select-sm">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            <div class="col-6 col-md-2">
                <button class="btn btn-outline-light btn-sm">Filter</button>
            </div>
            <div class="col-6 col-md-2">
                <a href="{{ route('wishlist.list') }}" class="btn btn-outline-danger btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Attribute</th>
                    <th>Value</th>
                    <th>Added On</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wishlists as $wishlist)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($wishlist->customer)
                                <div class="fw-semibold">{{ $wishlist->customer->name }} </div>
                                <div class="text-muted small">{{ $wishlist->customer->email }}</div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="color:blue"><a href="{{ route('product.view', $wishlist->product->id) }}">{{ $wishlist->product?->name ?? '—' }}</a></td>
                        <td>{{ $wishlist->productAttribute?->attribute_name ?? '—' }}</td>
                        <td>{{ $wishlist->productAttribute?->attribute_value ?? '—' }}</td>
                        <td>{{ $wishlist->added_at?->format('d M, Y h:i A') ?? '—' }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No wishlist records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($wishlists, 'links'))
        <div class="px-3 pb-3">
            {{ $wishlists->links() }}
        </div>
    @endif
</section>

@endsection
