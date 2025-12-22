<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Gate it if you need; keep open for now
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'         => ['required', 'exists:customers,id'],
            'customer_address_id' => ['required', 'exists:customer_addresses,id'],

            'receiver_name'  => ['nullable', 'string', 'max:255'],
            'receiver_phone' => ['nullable', 'string', 'max:30'],

            'payment_method' => ['required', Rule::in(['COD','online'])],
            'payment_status' => ['required', Rule::in(['pending','processing','cancel','failed','success','refunded'])],
            'payment_channel'=> ['nullable','string','max:100'],
            'transaction_id' => ['nullable','string','max:100'],

            'order_note' => ['nullable','string'],
            'remarks'    => ['nullable','string'],

            'delivery_charge' => ['required','numeric','min:0'],
            'discount_amount' => ['nullable','numeric','min:0'],

            'status' => ['required', Rule::in(['pending','confirm','dispatched','delivered','cancelled','returned','success'])],

            'items'                        => ['required','array','min:1'],
            'items.*.product_id'           => ['required','exists:products,id'],
            'items.*.product_attribute_id' => ['required','exists:product_attributes,id'],
            'items.*.quantity'             => ['required','integer','min:1'],

            // client money fields are ignored on server, keep soft validation to avoid trash
            'items.*.unit_price'      => ['nullable','numeric','min:0'],
            'items.*.discount_amount' => ['nullable','numeric','min:0'],
            'items.*.sub_total'       => ['nullable','numeric','min:0'],
            'items.*.payable'         => ['nullable','numeric','min:0'],
            'items.*.coupon_id'       => ['nullable','exists:coupons,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'     => 'Order must contain at least one item.',
            'items.min'          => 'Order must contain at least one item.',
            'customer_id.exists' => 'Selected customer is invalid.',
            'customer_address_id.exists' => 'Selected address is invalid.',
        ];
    }
}
