@extends('master')

@section('contents')

@php
    $fmt = fn($n) => number_format((float)$n, 2);
@endphp

<style>
    .badge-pill { border-radius:999px; padding:.35rem .6rem; font-size:.75rem; }
    .badge-green { background:#dcfce7; color:#166534; }
    .badge-red   { background:#fee2e2; color:#991b1b; }
    .badge-blue  { background:#dbeafe; color:#1e40af; }
    .badge-yellow{ background:#fef9c3; color:#854d0e; }
    .badge-gray  { background:#f1f5f9; color:#334155; }

    .cardish { background:#fff; border-radius:10px; box-shadow:0 1px 8px rgba(16,24,40,.06); }
    .product-img { width: 70%; max-height: 320px; object-fit: cover; border-radius: 10px; }
    .attr-card { background: #f9fafb; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; }
    .attr-img { width:60px; height:60px; border-radius:6px; object-fit:cover; border:1px solid #ddd; margin-right:6px; }
</style>

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="fs-5 m-0">Product Details</h3>
        <a href="{{ route('product.list') }}" class="btn btn-outline-light btn-sm">← Back to Products</a>
    </div>

    <div class="bg-white p-4 rounded-bottom">
        <!-- Top Section -->
        <div class="row g-4 align-items-start">
            <div class="col-md-4 text-center">
                <img src="{{ $product->primary_image }}" class="product-img border" alt="Product Image">
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="fw-semibold mb-0" style="font-size: 20px;">{{ $product->name }}</p>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-outline-primary btn-sm">
                        Edit
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge badge-pill {{ $product->status == 'active' ? 'badge-green' : ($product->status == 'out_of_stock' ? 'badge-yellow' : 'badge-red') }}">
                        {{ ucfirst($product->status) }}
                    </span>
                    <span class="badge badge-pill badge-blue">{{ ucfirst($product->product_type) }}</span>
                </div>

                <div class="col-md-12 mt-3">
                    <table class="table table-borderless align-middle mb-0">

                        <tbody>
                            <tr>
                                <th class="text-secondary fw-medium">Category</th>
                                <td class="fw-semibold text-dark text-truncate">{{ $product->category?->name ?? '—' }}</td>
                
                                <th class="text-secondary fw-medium">Brand</th>
                                <td class="fw-semibold text-dark text-truncate">{{ $product->brand?->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary fw-medium">Slug</th>
                                <td class="fw-semibold text-dark text-truncate">{{ $product->slug }}</td>
                
                                <th class="text-secondary fw-medium">Product Type</th>
                                <td class="fw-semibold text-dark">{{ ucfirst($product->product_type) }}</td>
                            </tr>
                            <tr>
                                <th class="text-secondary fw-medium">Status</th>
                                <td>
                                    <span class="badge badge-pill 
                                        {{ $product->status == 'active' ? 'badge-green' : 
                                           ($product->status == 'out_of_stock' ? 'badge-yellow' : 'badge-red') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                
                                <th class="text-secondary fw-medium">Created At</th>
                                <td class="fw-semibold text-dark">{{ $product->created_at?->format('d M, Y h:i A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

        <hr class="my-4">

        <!-- Attributes Section -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0">Product Attributes</h5>
            </div>

            @if($product->attributes->count())
                <div class="row g-3">
                    @foreach($product->attributes as $attr)
                        <div class="col-md-6">
                            <div class="attr-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="m-0 fw-semibold">{{ $attr->attribute_name }}: <span class="text-muted">{{ $attr->attribute_value }}</span></h6>
                                    @if($attr->is_default)
                                        <span class="badge badge-pill badge-blue">Default</span>
                                    @endif
                                </div>

                                <div class="row small text-muted">
                                    <div class="col-6">
                                        <strong>Unit Price:</strong> {{ $fmt($attr->unit_price) }} ৳
                                    </div>
                                    <div class="col-6">
                                        <strong>Stock:</strong> {{ $attr->stock }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Min Order:</strong> {{ $attr->min_order }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Max Order:</strong> {{ $attr->max_order ?? '—' }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Discount:</strong>
                                        @if($attr->discount_type)
                                            {{ $attr->discount_type == 'fixed' ? $fmt($attr->discount_amount).' ৳' : $attr->discount_amount.'%' }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <strong>Status:</strong>
                                        <span class="badge badge-pill {{ $attr->status ? 'badge-green' : 'badge-red' }}">
                                            {{ $attr->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>

                                @if($attr->attribute_images && count($attr->attribute_images))
                                    <div class="mt-3">
                                        <strong>Images:</strong>
                                        <div class="d-flex flex-wrap mt-2">
                                            @foreach($attr->attribute_images as $img)
                                                <img src="{{ asset($img->image_path) }}" alt="" class="attr-img">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted py-4 text-center">No attributes found for this product.</div>
            @endif
        </div>
    </div>
</div>

@endsection
