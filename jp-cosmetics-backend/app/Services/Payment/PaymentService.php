<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\App;

class PaymentService
{
    protected PaymentGatewayInterface $gateway;

    public function __construct()
    {
        $default = config('app.paymentGateway');

        $this->gateway = match ($default) {
            'sslCommerz' => App::make(SslCommerzGatewayService::class),
            default => App::make(SslCommerzGatewayService::class),
        };

    }

    public function payNow($order)
    {
        return $this->gateway->pay($order);
    }
}
