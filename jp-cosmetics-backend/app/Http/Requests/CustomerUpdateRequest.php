<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $customerId = $this->route('id');  // Assuming 'customer' is the route parameter for the customer ID

        return [
            'name' => ['required', 'string', 'max:500'],
            'email' => ['required', 'email', 'unique:customers,email,' . $customerId],
            'phone' => ['required', 'string', 'max:15'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'status' => ['required', 'in:active,inactive,banned'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096'],
            'addresses' => ['nullable', 'array'],
            'addresses.*.id' => ['nullable', 'exists:customer_addresses,id'],
            'addresses.*.title' => ['required', 'string', 'max:100'],
            'addresses.*.city' => ['required', 'string', 'max:100'],
            'addresses.*.area' => ['nullable', 'string', 'max:150'],
            'addresses.*.address' => ['required', 'string'],
            'addresses.*.status' => ['required', 'boolean'],
            'addresses.*.is_default' => [ 'boolean'],
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The first name is required.',
            'email.required' => 'The email address is required.',
            'phone.required' => 'The phone number is required.',
            'gender.required' => 'Please select a gender.',
            'status.required' => 'Please select a status.',
            'image.image' => 'The uploaded file must be an image.',
            'addresses.*.title.required' => 'The address title is required.',
            'addresses.*.city.required' => 'The city is required.',
            'addresses.*.address.required' => 'The address is required.',
        ];
    }
}
