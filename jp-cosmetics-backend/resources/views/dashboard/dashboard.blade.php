@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden shadow">

    <div class="p-2 px-4 d-flex justify-content-between align-items-center"
         style="background-color: rgb(119, 82, 125); color:#ffffff">
        <h3 class="text-md m-0">Dashboard</h3>
        <small class="opacity-75">{{ now()->format('d M, Y') }}</small>
    </div>

    <div class="p-4">

        {{-- KPI Cards --}}
        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Total Orders</div>
                    <div class="fs-4 fw-bold">{{ $totalOrders }}</div>
                    <div class="text-muted small">Today: {{ $todayOrders }}</div>
                    <a class="small" href="{{ route('order.list') }}">View orders</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Pending Orders</div>
                    <div class="fs-4 fw-bold">{{ $pendingOrders }}</div>
                    <div class="text-danger small">Needs attention</div>
                    <a class="small" href="{{ route('order.list') }}">Go to orders</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Sales (Today)</div>
                    <div class="fs-4 fw-bold">
                        ৳ {{ rtrim(rtrim(number_format($todaySales, 2, '.', ''), '0'), '.') }}
                    </div>
                    <div class="text-muted small">
                        This month: ৳ {{ rtrim(rtrim(number_format($monthSales, 2, '.', ''), '0'), '.') }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Low Stock (≤ {{ $lowStockThreshold }})</div>
                    <div class="fs-4 fw-bold">{{ $lowStockCount }}</div>
                    <div class="text-muted small">Out of stock: {{ $outOfStockCount }}</div>
                </div>
            </div>
        </div>

        {{-- Second Row --}}
        <div class="row g-3 mt-2">
            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Customers</div>
                    <div class="fs-4 fw-bold">{{ $totalCustomers }}</div>
                    <a class="small" href="{{ route('customer.list') }}">View customers</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Active Products</div>
                    <div class="fs-4 fw-bold">{{ $activeProducts }}</div>
                    <a class="small" href="{{ route('product.list') }}">View products</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Active Coupons</div>
                    <div class="fs-4 fw-bold">{{ $activeCoupons }}</div>
                    <a class="small" href="{{ route('coupon.list') }}">View coupons</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 rounded shadow-sm bg-light">
                    <div class="text-muted small">Delivered Orders</div>
                    <div class="fs-4 fw-bold">{{ $deliveredOrders }}</div>
                    <a class="small" href="{{ route('order.list') }}">View orders</a>
                </div>
            </div>
        </div>

        {{-- Charts + Quick Actions --}}
        <div class="row g-3 mt-3">
            <div class="col-lg-8">
                <div class="p-3 rounded shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-semibold">Sales & Orders (Last 7 Days)</div>
                        <small class="text-muted">Auto from DB</small>
                    </div>

                    {{-- IMPORTANT: chart container needs height --}}
                    <div style="height: 260px;">
                        <canvas id="salesChart"></canvas>
                    </div>

                    <div class="mt-2 text-muted small">
                        Labels: {{ implode(', ', $chartLabels) }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-3 rounded shadow-sm border">
                    <div class="fw-semibold mb-2">Quick Actions</div>
                    <div class="d-grid gap-2">
                        @hasPermission('product.create')
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">+ Create Product</a>
                        @endHasPermission

                        @hasPermission('category.create')
                        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">+ Create Category</a>
                        @endHasPermission

                        @hasPermission('coupon.create')
                        <a href="{{ route('coupon.create') }}" class="btn btn-primary btn-sm">+ Create Coupon</a>
                        @endHasPermission

                        <a href="{{ route('order.list') }}" class="btn btn-outline-dark btn-sm">View Orders</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Orders + Low Stock --}}
        <div class="row g-3 mt-3">
            <div class="col-lg-8">
                <div class="p-3 rounded shadow-sm border">
                    <div class="fw-semibold mb-2">Recent Orders</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $o)
                                    <tr>
                                        <td class="fw-semibold">#{{ $o->order_number }}</td>
                                        <td>{{ $o->customer->name ?? '—' }}</td>
                                        <td>
                                            ৳ {{ rtrim(rtrim(number_format($o->payable_total, 2, '.', ''), '0'), '.') }}
                                        </td>
                                        <td class="text-uppercase">{{ $o->payment_method }}</td>
                                        <td><span class="badge bg-secondary">{{ $o->status }}</span></td>
                                        <td class="text-muted small">{{ $o->created_at->diffForHumans() }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('order.show', $o->id) }}" class="btn btn-sm btn-outline-dark">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-3 rounded shadow-sm border">
                    <div class="fw-semibold mb-2">Low Stock Alerts</div>

                    @forelse($lowStockItems as $a)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ $a->product->name ?? '—' }}</div>
                                <div class="text-muted small">{{ $a->attribute_name }}: {{ $a->attribute_value }}</div>
                            </div>
                            <span class="badge bg-danger align-self-center">{{ $a->stock }} left</span>
                        </div>
                    @empty
                        <div class="text-muted small">No low stock items.</div>
                    @endforelse

                    <div class="pt-2">
                        <a href="{{ route('product.list') }}" class="btn btn-sm btn-outline-primary w-100">Go to Products</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ✅ Chart.js CDN inside this blade (as you requested) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data from controller
    const chartLabels = @json($chartLabels);
    const salesByDay  = @json($salesByDay);
    const ordersByDay = @json($ordersByDay);

    const canvas = document.getElementById('salesChart');

    // Extra safety: if canvas not found, don't error
    if (canvas && typeof Chart !== 'undefined') {
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Sales (BDT)',
                        data: salesByDay,
                        borderWidth: 2,
                        tension: 0.35,
                        fill: false
                    },
                    {
                        label: 'Orders',
                        data: ordersByDay,
                        borderWidth: 2,
                        tension: 0.35,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    } else {
        console.log('Chart.js not loaded or canvas missing.');
    }
</script>

@endsection
