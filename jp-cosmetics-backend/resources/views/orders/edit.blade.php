@extends('master')

@section('contents')

@php
    $fmt = fn($n) => number_format((float)$n, 2);
@endphp

<style>
    .badge-pill { border-radius: 999px; padding: .35rem .6rem; font-size: .75rem; }
    .badge-gray { background:#eef2f7; color:#334155; }
    .badge-green { background:#dcfce7; color:#166534; }
    .badge-blue  { background:#dbeafe; color:#1e40af; }
    .badge-yellow{ background:#fef9c3; color:#854d0e; }
    .badge-red   { background:#fee2e2; color:#991b1b; }
    .badge-purple{ background:#f3e8ff; color:#6b21a8; }
    .badge-slate { background:#e2e8f0; color:#0f172a; }

    .cardish { background:#fff; border-radius: 10px; box-shadow: 0 1px 8px rgba(16,24,40,.06); }
    .kv { display:flex; gap:8px; align-items:center; }
    .kv .k { min-width: 140px; color:#475569; }
    .muted { color:#6b7280; }
</style>

<div class="rounded shadow-sm">
    <div class="p-3 rounded-top d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <div>
            <div>
                <h3 class="fs-5 m-0 d-flex align-items-center gap-2">
                    <span>Edit Order #{{ $order?->order_number ?? '—' }}</span>
                    <small class="fw-normal" style="color:rgb(196, 196, 196)">
                        ({{ $order?->created_at?->format('Y-m-d, H:i') ?? '—' }})
                    </small>
                </h3>
            </div>
        </div>
        <div class="d-flex gap-2 align-items-center">
            @php
                $pmBadge = ($order->payment_method === 'COD') ? 'badge-yellow' : 'badge-blue';
                $psBadge = match($order->payment_status) {
                    'success'   => 'badge-green',
                    'processing'=> 'badge-blue',
                    'pending'   => 'badge-slate',
                    'refunded'  => 'badge-purple',
                    'cancel', 'failed' => 'badge-red',
                    default     => 'badge-gray'
                };
                $stBadge = match($order->status) {
                    'success'   => 'badge-green',
                    'delivered' => 'badge-green',
                    'confirm'   => 'badge-blue',
                    'dispatched'=> 'badge-yellow',
                    'pending'   => 'badge-slate',
                    'returned'  => 'badge-purple',
                    'cancelled' => 'badge-red',
                    default     => 'badge-gray'
                };
            @endphp
            <span class="badge badge-pill {{ $pmBadge }}">{{ $order->payment_method }}</span>
            <span class="badge badge-pill {{ $psBadge }}">{{ ucfirst($order->payment_status) }}</span>
            <span class="badge badge-pill {{ $stBadge }}">{{ ucfirst($order->status) }}</span>
        </div>
    </div>

    <div class="bg-white p-4 rounded-bottom">
        {{-- Top: compact info --}}
        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <div class="cardish p-3 h-100">
                    <div class="fw-semibold mb-2">Order Summary</div>
                    <div class="kv"><div class="k">Subtotal</div><div class="v fw-semibold">{{ $fmt($order->sub_total_amount) }}</div></div>
                    <div class="kv"><div class="k">Delivery</div><div class="v fw-semibold">{{ $fmt($order->delivery_charge) }}</div></div>
                    <div class="kv"><div class="k">Discount</div><div class="v fw-semibold text-danger">- {{ $fmt($order->discount_amount ?? 0) }}</div></div>
                    <hr class="my-2">
                    <div class="kv"><div class="k">Payable</div><div class="v fw-bold fs-5">{{ $fmt($order->payable_total ?? 0) }}</div></div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="cardish p-3 h-100">
                    <div class="fw-semibold mb-2">Customer</div>
                    <div class="kv"><div class="k">Name</div><div class="v fw-semibold">{{ ($order->customer->name ?? '') }}</div></div>
                    <div class="kv"><div class="k">Email</div><div class="v">{{ $order->customer->email ?? '—' }}</div></div>
                    <div class="kv"><div class="k">Phone</div><div class="v">{{ $order->customer->phone ?? '—' }}</div></div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="cardish p-3 h-100">
                    <div class="fw-semibold mb-2">Ship To</div>
                    @if($order->address)
                        <div class="kv"><div class="k">Receiver</div><div class="v">{{ $order->receiver_name ?? $order->customer->name ?? '' }}</div></div>
                        <div class="kv"><div class="k">Phone</div><div class="v">{{ $order->receiver_phone ?? ($order->customer->phone ?? '—') }}</div></div>
                        <div class="kv"><div class="k">Address</div><div class="v">{{ $order->address->address }}</div></div>
                        <div class="kv"><div class="k">Area/City</div><div class="v">{{ $order->address->area ? $order->address->area.', ' : '' }}{{ $order->address->city }}</div></div>
                    @else
                        <div class="muted">—</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Edit Form (only status & remarks) --}}
        <form action="{{ route('order.update', $order->id) }}" method="POST" class="mt-4">
            @csrf

            <div class="cardish p-3">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Order Status</label>
                        <select name="status" class="form-select" required>
                            @php
                                $statuses = ['pending','confirm','dispatched','delivered','cancelled','returned','success'];
                            @endphp
                            @foreach($statuses as $st)
                                <option value="{{ $st }}" {{ old('status', $order->status) === $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-8">
                        <label class="form-label fw-semibold">Remarks (optional)</label>
                        <textarea name="remarks" rows="3" class="form-control" placeholder="Any note for this status change...">{{ old('remarks', $order->remarks) }}</textarea>
                        @error('remarks') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>

        {{-- Optional: subtle hint of counts (no details) --}}
        <div class="mt-3 muted small">
            Items: {{ $order->details?->count() ?? 0 }} &middot; Created: {{ $order->created_at?->format('Y-m-d H:i') }}
        </div>

         {{-- Actions --}}
         <div class="mt-4 d-flex gap-2">
            <a href="{{ route('order.list') }}" class="btn btn-outline-secondary">
                ← Back to Orders
            </a>

        </div>
    </div>
</div>

@endsection
