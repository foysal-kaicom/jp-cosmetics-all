@extends('master')

@section('contents')

<style>
    .badge-pill { border-radius: 999px; padding: .35rem .6rem; font-size: .75rem; }
    .badge-gray { background:#eef2f7; color:#334155; }
    .badge-green { background:#dcfce7; color:#166534; }
    .badge-blue  { background:#dbeafe; color:#1e40af; }
    .badge-yellow{ background:#fef9c3; color:#854d0e; }
    .badge-red   { background:#fee2e2; color:#991b1b; }
    .badge-purple{ background:#f3e8ff; color:#6b21a8; }
    .badge-slate { background:#e2e8f0; color:#0f172a; }

    .order-card { background:#fff; border-radius:10px; box-shadow:0 1px 8px rgba(16,24,40,.06); }
</style>

<section class="w-100 bg-white rounded overflow-hidden shadow">
    <!-- Header -->
    <div class="py-3 px-4 d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="text-md m-0">Orders of {{ $customer->name }} </h3>
        <a href="{{ route('customer.list') }}" class="btn btn-outline-light btn-sm">← Back to Customers</a>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th class="d-none d-md-table-cell">Payment</th>
                    <th class="d-none d-md-table-cell">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $psBadge = match($order->payment_status) {
                            'success'    => 'badge-green',
                            'processing' => 'badge-blue',
                            'pending'    => 'badge-slate',
                            'refunded'   => 'badge-purple',
                            'cancel', 'failed' => 'badge-red',
                            default      => 'badge-gray'
                        };

                        $stBadge = match($order->status) {
                            'success'    => 'badge-green',
                            'delivered'  => 'badge-green',
                            'confirm'    => 'badge-blue',
                            'dispatched' => 'badge-yellow',
                            'pending'    => 'badge-slate',
                            'returned'   => 'badge-purple',
                            'cancelled'  => 'badge-red',
                            default      => 'badge-gray'
                        };
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="fw-semibold">{{ number_format($order->payable_total, 2) }} ৳</td>
                        <td class="d-none d-md-table-cell">
                            <span class="badge badge-pill {{ $psBadge }}">{{ ucfirst($order->payment_status) }}</span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span class="badge badge-pill {{ $stBadge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('order.show', $order->id) }}"
                               class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-medium bg-sky-500 text-white hover:bg-sky-600 shadow-md transition"
                               title="View Order Details">
                                <i class="fa-solid fa-eye"></i>
                                <span class="sr-only">View</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No orders found for this customer.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 pb-3">
        {{ $orders->links() }}
    </div>
    
</section>

@endsection
