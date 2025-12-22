<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\OrderListResource;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use App\Services\Payment\PaymentService;
use App\Services\Payment\SslCommerzGatewayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function currentCustomer()
    {
        $customer = Auth::guard('customer')->user();
        $customer->load(['addresses', 'defaultAddress']);

        return $this->responseWithSuccess(new CustomerResource($customer));
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return $this->responseWithError('Unauthorized', 401);
        }
    
        $order_number = strtoupper(Str::random(10));

        $sub_total_amount = 0;
        $total_discount   = 0;
        $total_payable    = 0;
        $discount_for_coupon = 0;
    
        $orderDetailsData = [];
        $stockUpdates     = [];

        foreach ($request->products as $item) {
    
            $quantity   = $item['quantity'];
            $unit_price = $item['unit_price'];

            $subtotal = $item['subtotal'] ?? ($unit_price * $quantity);

            $discount_amount = 0;
    
            if (!empty($item['discount_amount'])) {
                $discount_amount = $item['discount_amount'];
            } elseif (!empty($item['discount_percentage'])) {
                $discount_amount = ($item['discount_percentage'] / 100) * $subtotal;
            }
    
            $payable = $subtotal - $discount_amount;

            $sub_total_amount += $subtotal;
            $total_discount   += $discount_amount;
            $total_payable    += $payable;

            $orderDetailsData[] = [
                'product_id'           => $item['product_id'],
                'product_attribute_id' => $item['product_attribute_id'],
                'quantity'             => $quantity,
                'unit_price'           => $unit_price,
                'sub_total'            => $subtotal,
                'coupon_id'            => $request->coupon_id ?? null,
                'discount_amount'      => $discount_amount,
                'payable'              => $payable,
                'created_at'           => now(),
                'updated_at'           => now(),
            ];

            $stockUpdates[] = [
                'attribute_id' => $item['product_attribute_id'],
                'quantity'     => $quantity,
            ];
        }

        if(!empty($request->coupon_id)){
            $coupon = Coupon::findOrFail($request->coupon_id);

            if(!$coupon){
                return $this->responseWithError('Coupon not found');
            }

            $discount_for_coupon = $this->calculateCouponDiscount($coupon, $total_payable);
        }

        $payable_total = ($total_payable - $discount_for_coupon) + $request->delivery_charge;
        $total_discount = $total_discount + $discount_for_coupon;

        $order = Order::create([
            'customer_id'         => $customer->id,
            'order_number'        => $order_number,
            'sub_total_amount'    => $sub_total_amount,
            'delivery_charge'     => $request->delivery_charge,
            'discount_amount'     => $total_discount,
            'discount_from_coupon'=> $discount_for_coupon,
            'payable_total'       => $payable_total,
            'payment_status'      => Order::PENDING,
            'payment_method'      => $request->payment_method,
            'payment_channel'     => $request->payment_channel ?? null,
            'coupon_id'           => $request->coupon_id ?? null,
            'status'              => Order::PENDING,
            'receiver_name'       => $request->receiver_name,
            'receiver_email'      => $request->receiver_email,
            'receiver_phone'      => $request->receiver_phone,
            'shipping_city'       => $request->shipping_city,
            'shipping_area'       => $request->shipping_area,
            'shipping_location'   => $request->shipping_location,
            'customer_address_id' => $request->customer_address_id,
            'order_note'          => $request->order_note,
        ]);

        foreach ($orderDetailsData as &$row) {
            $row['order_id'] = $order->id;
        }
    
        OrderDetail::insert($orderDetailsData);

        if($request->payment_method == "online"){
            $payment = new PaymentService();
            $payres = $payment->payNow($order);
        }
    
        // foreach ($stockUpdates as $st) {
        //     ProductAttribute::where('id', $st['attribute_id'])
        //         ->decrement('stock', $st['quantity']);
        // }

        return $this->responseWithSuccess([
            'order_id'      => $order->id,
            'order_number'  => $order->order_number,
            'payable_total' => $order->payable_total,
            'payment_url' => $payres ?? null
        ], 'Order placed successfully');
    }

    private function calculateCouponDiscount($coupon, $subTotal)
    {
        if ($subTotal <= 0) {
            return 0;
        }

        if ($coupon->type === 'fixed') {
            $discount = $coupon->discount_value;
        } else { 
            $discount = $subTotal * ((float) $coupon->discount_value / 100);
        }

        if (!empty($coupon->max_discount)) {
            $discount = min($discount, (float) $coupon->max_discount);
        }

        return max(0, min($discount, $subTotal));
    }

    public function successPayment(Request $request){
        $sslCommerzService = new SslCommerzGatewayService();
        $url = $sslCommerzService->success($request);

        return redirect()->away($url);
    }

    public function failPayment(Request $request){
        $sslCommerzService = new SslCommerzGatewayService();
        $url = $sslCommerzService->fail($request);

        return redirect()->away($url);

    }

    public function cancelPayment(Request $request){
        $sslCommerzService = new SslCommerzGatewayService();
        $url = $sslCommerzService->cancel($request);

        return redirect()->away($url);
    }
    
    public function orderListOfaCustomer()
    {
        $customerId = auth('customer')->id();

        $orders = Order::where('customer_id', $customerId)
            ->with(['latestActivity', 'details.product:id,name'])
            ->latest()
            ->get();

        return $this->responseWithSuccess(OrderListResource::collection($orders));
    }
    
    public function showSpecificOrderDetails($orderNumber)
    {
        $customerId = auth('customer')->id();

        $order = Order::where('customer_id', $customerId)
            ->where('order_number', $orderNumber)
            ->with([
                'address',
                'details:id,order_id,product_id,product_attribute_id,quantity,unit_price,sub_total,discount_amount,payable,coupon_id',
                'details.product:id,name,slug,primary_image',
                'details.productAttribute:id,product_id,attribute_name,attribute_value',
                'activities' => fn($q) => $q->latest(),
            ])
            ->firstOrFail();

        return $this->responseWithSuccess(new OrderDetailsResource($order));
    }


    public function trackOrder(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->select('id') ->firstOrFail();

        $activities = $order->activities()
            ->select('id', 'order_id', 'from_status', 'to_status', 'remarks', 'created_at')
            ->latest()
            ->get();

        return $this->responseWithSuccess($activities);
    }

}
