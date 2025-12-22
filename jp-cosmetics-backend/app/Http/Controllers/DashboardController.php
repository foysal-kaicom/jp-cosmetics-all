<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductAttribute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $todayStart = Carbon::today();
        $todayEnd   = Carbon::tomorrow();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd   = Carbon::now()->endOfMonth();

        // -------------------------
        // KPI: Orders
        // -------------------------
        $totalOrders = Order::count();

        $todayOrders = Order::whereBetween('created_at', [$todayStart, $todayEnd])->count();

        $pendingOrders = Order::where('status', Order::PENDING)->count();

        // if you have constants like DELIVERED/CANCELLED, use them
        $deliveredOrders = defined(Order::class.'::DELIVERED')
            ? Order::where('status', Order::DELIVERED)->count()
            : Order::where('status', 'delivered')->count(); // fallback

        // -------------------------
        // KPI: Sales
        // -------------------------
        $todaySales = Order::whereBetween('created_at', [$todayStart, $todayEnd])
            ->whereIn('payment_status', ['success', 'processing', 'pending']) // adjust if needed
            ->sum('payable_total');

        $monthSales = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->whereIn('payment_status', ['success', 'processing', 'pending'])
            ->sum('payable_total');

        // -------------------------
        // Customers / Products / Coupons
        // -------------------------
        $totalCustomers = Customer::count();

        // If product has status column, use it; otherwise count all.
        $activeProducts = Product::query()
            ->when(Schema::hasColumn('products', 'status'), fn($q) => $q->where('status', 1))
            ->count();

        // Inventory (attributes stock)
        $lowStockThreshold = 5;

        $lowStockCount = ProductAttribute::where('status', 1)
            ->where('stock', '<=', $lowStockThreshold)
            ->count();

        $outOfStockCount = ProductAttribute::where('status', 1)
            ->where('stock', '=', 0)
            ->count();

        $activeCoupons = Coupon::where('status', 'active')->count();

        // -------------------------
        // Recent Orders
        // -------------------------
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(10)
            ->get();

        // -------------------------
        // Low Stock List (top 8)
        // -------------------------
        $lowStockItems = ProductAttribute::with('product:id,name,slug,primary_image')
            ->where('status', 1)
            ->where('stock', '<=', $lowStockThreshold)
            ->orderBy('stock', 'asc')
            ->take(8)
            ->get();

        // -------------------------
        // Simple Chart Data: last 7 days sales + orders
        // (for Chart.js later)
        // -------------------------
        $last7Days = collect(range(0, 6))->map(function ($i) {
            return Carbon::today()->subDays(6 - $i);
        });

        $salesByDay = [];
        $ordersByDay = [];

        foreach ($last7Days as $day) {
            $start = $day->copy()->startOfDay();
            $end   = $day->copy()->endOfDay();

            $salesByDay[] = (float) Order::whereBetween('created_at', [$start, $end])
                ->whereIn('payment_status', ['success', 'processing', 'pending'])
                ->sum('payable_total');

            $ordersByDay[] = (int) Order::whereBetween('created_at', [$start, $end])->count();
        }

        $chartLabels = $last7Days->map(fn($d) => $d->format('d M'))->toArray();

        return view('dashboard.dashboard', compact(
            'totalOrders',
            'todayOrders',
            'pendingOrders',
            'deliveredOrders',
            'todaySales',
            'monthSales',
            'totalCustomers',
            'activeProducts',
            'lowStockCount',
            'outOfStockCount',
            'activeCoupons',
            'recentOrders',
            'lowStockItems',
            'chartLabels',
            'salesByDay',
            'ordersByDay',
            'lowStockThreshold'
        ));
    }
    
    public function showProfile()
    {
        $superAdmin = Auth::user();
        return view('users.profile', compact('superAdmin'));
    }
}
