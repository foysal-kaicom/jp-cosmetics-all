<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentGatewayInterface;
use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\Payment;
use App\Services\StockService;

class SslCommerzGatewayService implements PaymentGatewayInterface
{

    public function pay($order)
    {
        $post_data = array();
        $post_data['total_amount'] = $order->payable_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $order->id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $order->receiver_name;
        $post_data['cus_email'] = $order->receiver_email;
        $post_data['cus_add1'] = $order->shipping_location;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = $order->shipping_city;
        $post_data['cus_state'] = $order->shipping_area;
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $order->receiver_phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "JP Cosmetics";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Cosmetics";
        $post_data['product_category'] = "Cosmetics";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'easyCheckout', true);

        return $payment_options['GatewayPageURL'];

    }


    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id'); 
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();
        $orderData = Order::findOrFail($tran_id);

        $successPath = str_replace('{order_id}', $orderData->id, config('app.frontend.payment_success'));
        $failedPath  = str_replace('{order_id}', $orderData->id, config('app.frontend.payment_failed'));
        $baseUrl     = config('app.frontend.url');

        if ($orderData->payment_status == 'pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                $orderData->update([
                    'payment_status' => Order::SUCCESS,
                    'status'         => Order::CONFIRM,
                ]);

            app(StockService::class)->reduceStockByOrderId($tran_id);

            // Mail::to($orderData->candidate->email)->queue(new BookingSuccessMail($orderData));

                return $baseUrl . $successPath;
            }
        }

        return $baseUrl . $failedPath;
    }

    public function fail(Request $request)
    {
        $baseUrl = config('app.frontend.url');
        $tran_id = $request->input('tran_id');
        $failedPath = str_replace('{booking_id}', $tran_id, config('app.frontend.payment_failed'));

        $orderData = Order::findOrFail($tran_id);

        if ($orderData) {
            $orderData->update([
                'payment_status' => Order::FAILED,
                'status'         => Order::CANCELLED,
            ]);
           
          //  Mail::to($orderData->candidate->email)->queue(new BookingFailedMail($orderData));
        }

        return $baseUrl . $failedPath;
    }

    public function cancel(Request $request)
    {
        $baseUrl = config('app.frontend.url');
        $tran_id = $request->input('tran_id');
        $failedPath = str_replace('{booking_id}', $tran_id, config('app.frontend.payment_cancel'));

        $orderData = Order::findOrFail($tran_id);

        if ($orderData) {
            $orderData->update([
                'payment_status' => Order::CANCELLED,
                'status'         => Order::CANCELLED,
            ]);

            $this->paymentTrack($orderData, $request->all());
           
           // Mail::to($orderData->candidate->email)->queue(new BookingCancelledMail($orderData));
        }

        return $baseUrl . $failedPath;
    }


    public function paymentTrack($bookingData, $requestData)
    {

        Payment::create([
            'booking_id'      => $bookingData->id, // existing bookings.id
            'type'            => 'booking',
            'amount'          => $bookingData->total_payable,
            'payment_method'  => $requestData['card_type'] ?? 'unknown',
            'status'          => $requestData['status'],
            // 'reference'       => 
            'additionals'     => json_encode($requestData),
        ]);
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
