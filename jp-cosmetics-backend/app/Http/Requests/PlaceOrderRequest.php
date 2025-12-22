<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products'                  => 'required|array|min:1',

            'products.*.product_id'           => 'required|exists:products,id',
            'products.*.product_attribute_id' => 'required|exists:product_attributes,id',
            'products.*.unit_price'           => 'required|numeric|min:0',
            'products.*.quantity'             => 'required|integer|min:1',
            'products.*.subtotal'             => 'nullable|numeric|min:0',
            'products.*.discount_amount'      => 'nullable|numeric|min:0',
            'products.*.discount_percentage'  => 'nullable|numeric|min:0|max:100',

            'customer_address_id'       => 'required|exists:customer_addresses,id',
            'receiver_name'             => 'required|string|max:255',
            'receiver_email'            => 'required|email|max:255',
            'receiver_phone'            => 'required|string|max:50',
            'shipping_city'             => 'required|string|max:100',
            'shipping_area'             => 'required|string|max:100',
            'shipping_location'         => 'required|string|max:255',
            'coupon_id'                 => 'nullable|exists:coupons,id',


            'delivery_charge'           => 'required|numeric|min:0',
            'payment_method'            => 'required|in:COD,online',
            'payment_status'            => 'required|in:pending,processing,cancel,failed,success,refunded',
            'order_note'                => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'At least one product is required to place an order.',
            'products.*.product_id.required' => 'Product ID is missing in cart item.',
            'products.*.product_attribute_id.required' => 'Product attribute is required.',
        ];
    }
}
